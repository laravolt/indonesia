# CSV Data Compression

The CSV files in this directory are stored in compressed format (`.gz`) to reduce repository size and improve download performance.

## How it works

1. **Compressed Storage**: All CSV files are stored as `.csv.gz` files
2. **Automatic Extraction**: When running the database seeder, compressed files are automatically extracted if needed
3. **Space Savings**: Compression reduces file size by approximately 75%

## File Structure

```
resources/csv/
├── provinces.csv.gz      # ~1.6MB (was ~4.4MB)
├── cities.csv.gz         # ~2.3MB (was ~6.2MB)
├── districts.csv.gz      # ~4.0MB (was ~11MB)
└── villages/
    ├── 11.csv.gz         # ~4.3MB (was ~16MB)
    ├── 12.csv.gz         # ~4.9MB (was ~18MB)
    └── ...               # Total villages: ~25MB (was ~100MB+)
```

## Usage

The compression is transparent to users. Simply run the seeder as usual:

```bash
php artisan db:seed --class="Laravolt\Indonesia\Seeds\DatabaseSeeder"
```

The seeder will automatically:

1. Extract compressed files if CSV files don't exist
2. Use the extracted CSV files for seeding
3. Keep extracted files for subsequent runs (until manually deleted)

## Manual Operations

### Extract all files manually:

```bash
# Main CSV files
cd resources/csv
gunzip -k *.csv.gz

# Village files
cd villages
gunzip -k *.csv.gz
```

### Compress files manually:

```bash
# Main CSV files
cd resources/csv
gzip -k *.csv

# Village files
cd villages
gzip -k *.csv
```

### Clean up extracted files:

```bash
# Remove extracted CSV files (keeps .gz files)
cd resources/csv
rm *.csv
cd villages
rm *.csv
```

## Git Ignore

The `.gitignore` file is configured to:

- Track compressed files (`.csv.gz`)
- Ignore uncompressed files (`.csv`)

This ensures the repository only contains the compressed versions while allowing local extraction for development.
