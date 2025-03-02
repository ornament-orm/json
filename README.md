# json
JSON helpers for Ornament ORM

## Installation
```sh
$ composer require ornament/json
```

## Usage
This packaged provides the `Json` decorator, which automagically calls
`json_decode` on a string value (storage drivers usually don't do that for you).
The decorator throws a `DomainException` if the string passed is not valid JSON.
If the value input is not a string, it is used verbatim.

Additionally, it provides two helpful traits: `SerializeAll` and
`SerializeOnlyPublic`. The first makes the property serializable; the second
also, but only exposes the public properties.

## Caveats
While `null` is a valid value to encapsulate in a JSON string, it is assumed
that this value is _not_ valid. The decoded JSON should be either an object or
an array - encoding `null` as JSON in a storage engine just doesn't... make a
lot of sense.

