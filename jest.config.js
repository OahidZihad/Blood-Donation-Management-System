/** @type {import('jest').Config} */
module.exports = {
  testEnvironment: 'node',
  testMatch: ['**/tests/**/*.test.js'],
  reporters: [
    'default',
    ['jest-junit', { outputFile: 'junit.xml' }]
  ]
};
