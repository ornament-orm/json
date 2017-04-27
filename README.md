# json
JSON helpers for Ornament ORM

## Installation
```sh
$ composer require ornament/json
```

## Usage
This package consists of two traits one can `use` for easy JSON seriliazing, as
well as a property decorator for JSON properties.

## The serializers
Models should implement the `JsonSerializable` interface. Then, simply `use`
either `SerializeAll` (to enable serialization of both public and protected
properties) or `SerializeOnlyPublic` (for only public properties).

## The decorator
Annotate your property with `@var Ornament\Json\Property`. If the value is
input as a string, the decorator tries to `json_decode()` it. If the value is
not a string to begin with, it is left alone.

