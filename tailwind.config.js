/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    'source/**/*.blade.php',
    'source/**/*.md',
    'source/**/*.js',
  ],
  safelist: [
    { pattern: /language/ },
    { pattern: /hljs/ },
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
      },
      maxWidth: {
        '8xl': '88rem',
      },
    },
  },
  plugins: [],
}
