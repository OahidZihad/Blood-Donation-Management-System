/**
 * Regression tests for:
 *   Search Functionality Missing from All List Pages
 *
 * These tests parse the PHP source files and assert that:
 *  1. A GET-based search <form> exists on each list page.
 *  2. The relevant $_GET parameter(s) are read.
 *  3. A prepared statement (prepare + bind_param) is used for filtering,
 *     protecting against SQL injection.
 *  4. A WHERE clause is conditionally applied.
 *
 * Before the fix all three files contained bare `SELECT * FROM <table>`
 * with no form and no GET handling — each assertion below would have failed.
 */

const fs = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');

function readFile(filename) {
  return fs.readFileSync(path.join(ROOT, filename), 'utf8');
}

// ─────────────────────────────────────────────
// available_blood.php
// ─────────────────────────────────────────────
describe('available_blood.php — search by blood_group', () => {
  let src;
  beforeAll(() => { src = readFile('available_blood.php'); });

  test('has a GET form for search', () => {
    expect(src).toMatch(/method\s*=\s*["']GET["']/i);
  });

  test('reads $_GET["blood_group"]', () => {
    expect(src).toMatch(/\$_GET\s*\[\s*['"]blood_group['"]\s*\]/);
  });

  test('uses a prepared statement (prepare call present)', () => {
    expect(src).toMatch(/\$conn->prepare\s*\(/);
  });

  test('uses bind_param to bind the LIKE value', () => {
    expect(src).toMatch(/bind_param\s*\(/);
  });

  test('SQL contains a WHERE clause with LIKE', () => {
    expect(src).toMatch(/WHERE\s+blood_group\s+LIKE\s+\?/i);
  });

  test('has conditional branching — bare SELECT is no longer the entire query logic', () => {
    // Before the fix: only one SELECT with no conditional branch.
    // After the fix: the file contains an if/else that picks filtered or full query.
    // We verify the file has both a prepared WHERE query AND the fallback SELECT,
    // confirming the conditional structure exists.
    expect(src).toMatch(/if\s*\(\s*\$search_blood_group/);
    expect(src).toMatch(/\}\s*else\s*\{/);
  });
});

// ─────────────────────────────────────────────
// available_donor_list.php
// ─────────────────────────────────────────────
describe('available_donor_list.php — search by name and blood_group', () => {
  let src;
  beforeAll(() => { src = readFile('available_donor_list.php'); });

  test('has a GET form for search', () => {
    expect(src).toMatch(/method\s*=\s*["']GET["']/i);
  });

  test('reads $_GET["name"]', () => {
    expect(src).toMatch(/\$_GET\s*\[\s*['"]name['"]\s*\]/);
  });

  test('reads $_GET["blood_group"]', () => {
    expect(src).toMatch(/\$_GET\s*\[\s*['"]blood_group['"]\s*\]/);
  });

  test('uses a prepared statement (prepare call present)', () => {
    expect(src).toMatch(/\$conn->prepare\s*\(/);
  });

  test('uses bind_param to bind search values', () => {
    expect(src).toMatch(/bind_param\s*\(/);
  });

  test('SQL contains WHERE clause when filtering', () => {
    expect(src).toMatch(/WHERE/i);
  });

  test('has conditional branching — bare SELECT is no longer the entire query logic', () => {
    // Before the fix: only one SELECT with no conditional branch.
    // After the fix: the file contains an if/else that picks filtered or full query.
    expect(src).toMatch(/if\s*\(\s*\$search_name\s*!==\s*''\s*\|\|\s*\$search_blood_group/);
    expect(src).toMatch(/\}\s*else\s*\{/);
  });
});

// ─────────────────────────────────────────────
// available_seeker_list.php
// ─────────────────────────────────────────────
describe('available_seeker_list.php — search by name and blood_group', () => {
  let src;
  beforeAll(() => { src = readFile('available_seeker_list.php'); });

  test('has a GET form for search', () => {
    expect(src).toMatch(/method\s*=\s*["']GET["']/i);
  });

  test('reads $_GET["name"]', () => {
    expect(src).toMatch(/\$_GET\s*\[\s*['"]name['"]\s*\]/);
  });

  test('reads $_GET["blood_group"]', () => {
    expect(src).toMatch(/\$_GET\s*\[\s*['"]blood_group['"]\s*\]/);
  });

  test('uses a prepared statement (prepare call present)', () => {
    expect(src).toMatch(/\$conn->prepare\s*\(/);
  });

  test('uses bind_param to bind search values', () => {
    expect(src).toMatch(/bind_param\s*\(/);
  });

  test('SQL contains WHERE clause when filtering', () => {
    expect(src).toMatch(/WHERE/i);
  });

  test('has conditional branching — bare SELECT is no longer the entire query logic', () => {
    // Before the fix: only one SELECT with no conditional branch.
    // After the fix: the file contains an if/else that picks filtered or full query.
    expect(src).toMatch(/if\s*\(\s*\$search_name\s*!==\s*''\s*\|\|\s*\$search_blood_group/);
    expect(src).toMatch(/\}\s*else\s*\{/);
  });
});
