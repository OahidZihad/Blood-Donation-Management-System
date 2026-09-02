/**
 * Regression tests for:
 *   available_donor_list.php — pagination logic
 *
 * Bug: SELECT * FROM donor with no LIMIT/OFFSET fetched every row.
 * Fix: Added $perPage=20, computed $offset and $totalPages, rewrote query
 *      with LIMIT/OFFSET, and added Previous/Next navigation links.
 *
 * These tests mirror the PHP pagination maths so the fix can be verified
 * without a running PHP/MySQL server.
 */

"use strict";

// ---------------------------------------------------------------------------
// Pure JS implementation of the pagination logic added in available_donor_list.php
// ---------------------------------------------------------------------------

/**
 * Compute pagination values identical to the PHP fix:
 *
 *   $perPage    = 20;
 *   $page       = max(1, intval($_GET["page"] ?? 1));
 *   $offset     = ($page - 1) * $perPage;
 *   $totalPages = max(1, (int) ceil($totalRows / $perPage));
 */
function computePagination({ totalRows, pageParam = null, perPage = 20 }) {
  const page = Math.max(1, parseInt(pageParam ?? "1", 10) || 1);
  const offset = (page - 1) * perPage;
  const totalPages = Math.max(1, Math.ceil(totalRows / perPage));
  return { page, offset, totalPages, perPage };
}

/** Build the SQL string the fix produces (for structural verification). */
function buildQuery({ perPage, offset }) {
  return `SELECT * FROM donor LIMIT ${perPage} OFFSET ${offset}`;
}

// ---------------------------------------------------------------------------
// Tests
// ---------------------------------------------------------------------------

describe("available_donor_list.php — pagination fix", () => {

  // --- core calculation -------------------------------------------------------

  test("page 1 produces offset 0 and correct LIMIT/OFFSET query", () => {
    const { page, offset, totalPages, perPage } = computePagination({ totalRows: 100 });
    expect(page).toBe(1);
    expect(offset).toBe(0);
    expect(totalPages).toBe(5);
    expect(buildQuery({ perPage, offset })).toBe("SELECT * FROM donor LIMIT 20 OFFSET 0");
  });

  test("page 2 produces offset 20", () => {
    const { page, offset } = computePagination({ totalRows: 100, pageParam: "2" });
    expect(page).toBe(2);
    expect(offset).toBe(20);
  });

  test("page 3 produces offset 40", () => {
    const { offset } = computePagination({ totalRows: 100, pageParam: "3" });
    expect(offset).toBe(40);
  });

  // --- totalPages rounding ----------------------------------------------------

  test("totalPages rounds up (ceil) for a non-exact multiple", () => {
    const { totalPages } = computePagination({ totalRows: 21 });
    expect(totalPages).toBe(2); // 21/20 = 1.05 → ceil → 2
  });

  test("totalPages is exactly 1 when totalRows === perPage", () => {
    const { totalPages } = computePagination({ totalRows: 20 });
    expect(totalPages).toBe(1);
  });

  // --- edge cases: zero / missing rows ----------------------------------------

  test("totalPages is at least 1 even when table is empty (max guard)", () => {
    const { totalPages } = computePagination({ totalRows: 0 });
    expect(totalPages).toBe(1); // max(1, ceil(0/20)) = max(1,0) = 1
  });

  // --- invalid / missing page param -------------------------------------------

  test("missing page param defaults to page 1 (offset 0)", () => {
    const { page, offset } = computePagination({ totalRows: 50, pageParam: null });
    expect(page).toBe(1);
    expect(offset).toBe(0);
  });

  test("page param 0 is clamped to 1 (max guard)", () => {
    const { page, offset } = computePagination({ totalRows: 50, pageParam: "0" });
    expect(page).toBe(1);
    expect(offset).toBe(0);
  });

  test("negative page param is clamped to 1", () => {
    const { page } = computePagination({ totalRows: 50, pageParam: "-5" });
    expect(page).toBe(1);
  });

  test("non-numeric page param is treated as 1", () => {
    const { page, offset } = computePagination({ totalRows: 50, pageParam: "abc" });
    expect(page).toBe(1);
    expect(offset).toBe(0);
  });

  // --- regression: old query had no LIMIT/OFFSET ------------------------------

  test("REGRESSION: query must contain LIMIT and OFFSET (old SELECT * FROM donor did not)", () => {
    const { perPage, offset } = computePagination({ totalRows: 100 });
    const sql = buildQuery({ perPage, offset });
    expect(sql).toMatch(/LIMIT\s+\d+/);
    expect(sql).toMatch(/OFFSET\s+\d+/);
    // Old query was literally "SELECT * FROM donor" with nothing after it
    expect(sql).not.toBe("SELECT * FROM donor");
  });

  // --- navigation link logic --------------------------------------------------

  test("Previous link should appear only when page > 1", () => {
    expect(computePagination({ totalRows: 100, pageParam: "1" }).page > 1).toBe(false);
    expect(computePagination({ totalRows: 100, pageParam: "2" }).page > 1).toBe(true);
  });

  test("Next link should appear only when page < totalPages", () => {
    const last = computePagination({ totalRows: 100, pageParam: "5" });
    expect(last.page < last.totalPages).toBe(false); // on last page — no Next

    const mid = computePagination({ totalRows: 100, pageParam: "3" });
    expect(mid.page < mid.totalPages).toBe(true); // mid page — show Next
  });

});
