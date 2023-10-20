# Changelog

## [0.5.0](https://github.com/nulldark/dbal/compare/v0.4.1...v0.5.0) (2023-10-20)


### Features

* add `transaction` func for wrapping transactions ([33b2e88](https://github.com/nulldark/dbal/commit/33b2e8860a264ceafea48a28239c9c1c8384125f))
* add connection manager ([5deea37](https://github.com/nulldark/dbal/commit/5deea3777716a622ac9d965e0d0404a2fc953aab))
* add support for FetchMode in QueryBuilder ([58bfc14](https://github.com/nulldark/dbal/commit/58bfc14dc9f95f09707b2fe02c9653d4529b0eb5))
* add transaction support ([5ba2c85](https://github.com/nulldark/dbal/commit/5ba2c856e16e755d7d1d84351f9caa4c1b54352c))
* Grammar classes ([#43](https://github.com/nulldark/dbal/issues/43)) ([71ee905](https://github.com/nulldark/dbal/commit/71ee9051ed02e00c21e469890b66b197330a9d31))
* implementing API interface that provides all metadata about the database platform. ([f0f43df](https://github.com/nulldark/dbal/commit/f0f43df4983b7caf1cfc20d3a773d0cf15a32543))


### Miscellaneous Chores

* downgrade phpstan level from max to 8 ([e3fab95](https://github.com/nulldark/dbal/commit/e3fab959f2e9e75fe0183bf1b87e336a90c09549))
* **release:** 0.5.0 ([b72a716](https://github.com/nulldark/dbal/commit/b72a71676d3b4966f1749a3755b72d13ea5d1f1b))
* some fixes ([943fc55](https://github.com/nulldark/dbal/commit/943fc5554ef298d9012de980b7331c8d4a50a1d7))

## [0.4.1](https://github.com/nulldark/dbal/compare/v0.4.0...v0.4.1) (2023-10-17)


### Bug Fixes

* Converting uppercase characters to lowercase because uppercase characters were causing a 'could not find driver' error ([f1951c2](https://github.com/nulldark/dbal/commit/f1951c2900828ce8ba9846418037dd01fc17496c))
