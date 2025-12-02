# JSONC Parser for PHP

A simple and efficient **JSONC (JSON with Comments) parser** for PHP.  
It allows you to read JSON files containing comments (`//` and `/* ... */`) safely in PHP projects.

## Features

- Supports single-line (`//`) and multi-line (`/* */`) comments
- Safe: comments inside string values are preserved
- Returns PHP array or object
- Compatible with Laravel and any PHP project

## Installation

Install via Composer:

```bash
composer require your-vendor/jsonc-parser
