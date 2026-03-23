# gTLD.fyi

A website to inform companies that their signup forms don't support gTLD domains for user accounts.

## Contributing

### Prerequisites

- PHP 8.5+
- Composer
- Node.js & npm

### Setup

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Local Development

```bash
# Build the site and compile assets for development
npm run dev

# Watch for changes and rebuild automatically
npm run watch
```

The built site will be output to `build_local/`.

### Production Build

```bash
# Build optimized assets for production
npm run prod

# Build the static site for production
./vendor/bin/jigsaw build production
```

## License

MIT
