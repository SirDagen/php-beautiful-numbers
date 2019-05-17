# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## 1.0.19 - 2019-05-17
### Added
- Subset of local language formats array added (accessable via "en-SI" instead of "en")


## 1.0.18 - 2019-05-14
### Changed 
- Faster rounding 


## 1.0.17 - 2019-05-13
### Added
- Spanish language added ("es")

### Changed
- Error in tnum() within 12<$val<100 fixed (outputted "19.0" instead of "19")


## 1.0.15 - 2019-05-13
### Added
- Rounding of big numbers ($val>100) in tnum() added (120.000 instead of 119.289)


## 1.0.14 - 2019-05-13
### Changed
- Parameters in tnum() and tsyn() changed to arrays (for easier use with multi-language sites)


