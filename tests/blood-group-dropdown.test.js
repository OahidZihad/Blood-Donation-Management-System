/**
 * Regression tests for the blood-group dropdown bugs in get_blood.php and update_stock.php.
 *
 * Bug 1: $conn->close() was called immediately after $conn->query(), before the result
 *        set was iterated inside the HTML body. On PHP 8.x this causes a fatal error
 *        ("Couldn't fetch mysqli_result"), making the option-rendering loop produce no output.
 *
 * Bug 2: $row[blood_group] used a bare (unquoted) constant as the array key. PHP 8.x
 *        treats undefined constants as errors; even on older PHP versions, it would
 *        emit a warning and use the literal string "blood_group" as option text instead
 *        of the actual blood group value.
 *
 * These tests assert that the fixed code does NOT contain the problematic patterns.
 */

const fs = require('fs');
const path = require('path');

const ROOT = path.resolve(__dirname, '..');
const GET_BLOOD = path.join(ROOT, 'get_blood.php');
const UPDATE_STOCK = path.join(ROOT, 'update_stock.php');

function readFile(filePath) {
  return fs.readFileSync(filePath, 'utf8');
}

describe('get_blood.php — blood-group dropdown', () => {
  let content;

  beforeAll(() => {
    content = readFile(GET_BLOOD);
  });

  test('does not use unquoted array key $row[blood_group]', () => {
    // The broken pattern is: $row[blood_group]  (no quotes around the key)
    // The fixed pattern is:  $row['blood_group']
    expect(content).not.toMatch(/\$row\[blood_group\]/);
  });

  test('uses correctly quoted array key $row[\'blood_group\']', () => {
    expect(content).toMatch(/\$row\['blood_group'\]/);
  });

  test('does not call $conn->close() before the option-rendering loop', () => {
    // The option-rendering loop starts with: while($row = $result->fetch_assoc())
    // $conn->close() must NOT appear before that line.
    const closePos = content.indexOf('$conn->close()');
    const loopPos = content.indexOf('$result->fetch_assoc()');

    if (closePos === -1) {
      // close() has been removed entirely — that's fine
      return;
    }
    // If close() exists, it must appear AFTER the fetch loop
    expect(closePos).toBeGreaterThan(loopPos);
  });
});

describe('update_stock.php — blood-group dropdown', () => {
  let content;

  beforeAll(() => {
    content = readFile(UPDATE_STOCK);
  });

  test('does not use unquoted array key $row[blood_group]', () => {
    expect(content).not.toMatch(/\$row\[blood_group\]/);
  });

  test('uses correctly quoted array key $row[\'blood_group\']', () => {
    expect(content).toMatch(/\$row\['blood_group'\]/);
  });

  test('does not call $conn->close() before the option-rendering loop', () => {
    const closePos = content.indexOf('$conn->close()');
    const loopPos = content.indexOf('$result->fetch_assoc()');

    if (closePos === -1) {
      return;
    }
    expect(closePos).toBeGreaterThan(loopPos);
  });
});
