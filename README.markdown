# Assetic Extensions

A repository for assorted extensions to the Assetic library.

Currently only contains a Cachbuster filter.

## CachebusterFilter

A simple filter to rewrite CSS URLs to append cachebusting tags to them.

For example:

    body { background: url(foo.gif); }

will become:

    body { background: url(foo.gif?v=12345); }

### Usage

For information on using Assetic filters, see
<https://github.com/kriswallsmith/assetic/blob/master/docs/en/concepts.md>
