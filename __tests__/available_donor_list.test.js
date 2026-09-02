/**
 * Regression test for:
 *   "No pagination in donor list — SELECT * loads all rows"
 *
 * Before the fix:  available_donor_list.php used `SELECT * FROM donor` with no
 *                  LIMIT or OFFSET and had no pagination navigation.
 * After the fix:   The file reads a `page` parameter, limits results to 20
 *                  rows per page, and renders Previous/Next links.
 */

const fs = require("fs");
const path = require("path");

const FILE_PATH = path.join(__dirname, "..", "available_donor_list.php");

let source;

beforeAll(() => {
  source = fs.readFileSync(FILE_PATH, "utf8");
});

describe("available_donor_list.php — pagination fix", () => {
  test("SQL query uses LIMIT to cap rows returned", () => {
    // Must contain LIMIT keyword (case-insensitive) in the donor query
    expect(source).toMatch(/SELECT \* FROM donor LIMIT/i);
  });

  test("SQL query uses OFFSET for page-based slicing", () => {
    expect(source).toMatch(/OFFSET\s+\$offset/i);
  });

  test("$perPage variable is defined", () => {
    expect(source).toMatch(/\$perPage\s*=/);
  });

  test("$page variable is read from $_GET with a safe default", () => {
    // Should read $_GET["page"] and default to 1
    expect(source).toMatch(/\$_GET\s*\[\s*["']page["']\s*\]/);
    expect(source).toMatch(/max\s*\(\s*1/);
  });

  test("$offset is calculated from $page and $perPage", () => {
    expect(source).toMatch(/\$offset\s*=\s*\(\s*\$page\s*-\s*1\s*\)\s*\*\s*\$perPage/);
  });

  test("Total row count query is present", () => {
    expect(source).toMatch(/SELECT COUNT\(\*\) AS total FROM donor/i);
  });

  test("$totalPages is computed", () => {
    expect(source).toMatch(/\$totalPages\s*=/);
    expect(source).toMatch(/ceil\s*\(/);
  });

  test("Previous page navigation link is present", () => {
    expect(source).toMatch(/Previous/i);
    expect(source).toMatch(/\$page\s*-\s*1/);
  });

  test("Next page navigation link is present", () => {
    expect(source).toMatch(/Next/i);
    expect(source).toMatch(/\$page\s*\+\s*1/);
  });

  test("Page indicator is rendered (Page X of Y)", () => {
    // PHP short echo tags: <?= $page ?> and <?= $totalPages ?>
    expect(source).toMatch(/Page\s*<\?=\s*\$page\s*\?>/);
    expect(source).toMatch(/of\s*<\?=\s*\$totalPages\s*\?>/);
  });
});
