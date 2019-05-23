# Changelog
All notable changes to this project will be documented in this file (tags: Added, Changed, Deprecated, Removed, Fixed, Security).

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).


## 1.0.23 - 2019-05-24
- Added: sinum() Overline an ambiguous significant zero in HTML
- Added "circa" to language list

## 1.0.22 - 2019-05-22
- Changed: Speed improvement in sinum() 

## 1.0.21 - 2019-05-21
- Added error option 'err' to sinum() which replaces 'acc' if wanted: ['err'=>0.02]
- Added scientific number format en-SC and de-WI 

## 1.0.20 - 2019-05-17
- Changed default unit value in sinum() to empty

## 1.0.19 - 2019-05-17
- Added subsets for local language format array (accessable via "en-SI", instead of the standard "en")

## 1.0.18 - 2019-05-14
- Changed: Faster rounding 

## 1.0.17 - 2019-05-13
- Added Spanish language ("es")
- Fixed error in tnum() within 12<$val<100 (outputted "19.0" instead of "19")

## 1.0.15 - 2019-05-13
- Added rounding of big numbers ($val>100) in tnum() (120.000 instead of 119.289)

## 1.0.14 - 2019-05-13
- Changed parameters in tnum() and tsyn() to arrays (for easier use with multi-language sites)

...
