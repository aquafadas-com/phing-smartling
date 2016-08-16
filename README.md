# Phing-Smartling
![Release](https://img.shields.io/packagist/v/aquafadas/phing-smartling.svg) ![License](https://img.shields.io/packagist/l/aquafadas/phing-smartling.svg) ![Downloads](https://img.shields.io/packagist/dt/aquafadas/phing-smartling.svg) ![Code quality](https://img.shields.io/codacy/grade/ef57f4e6c9b7483ab9f38673ca503703.svg) ![Build](https://img.shields.io/travis/aquafadas-com/phing-smartling.svg)

[Phing](https://www.phing.info) tasks dedicated to the synchronization of translations with the [Smartling](https://www.smartling.com) service, based on the [File API v2](http://docs.smartling.com/pages/API/v2).

## Getting Started
If you haven't used [Phing](https://www.phing.info) before, be sure to check out the [related documentation](https://www.phing.info/docs/guide/stable), as it explains how to create a `build.xml` as well as install and use user tasks.
Once you're familiar with that process, you may install the provided Phing classes with this command:

```shell
$ composer require --dev aquafadas/phing-smartling
```

Once the build tasks have been installed, they may be enabled inside your `build.xml`.

## Tasks

#### Download the message translations from the Smartling service
This task takes a file pattern as input, indicating the target path of the downloaded files.
The `{{locale}}` placeholder will be replaced by the locale of each file.

```xml
<taskdef classname="phing\smartling\tasks\DownloadTask" name="smartlingDownload"/>

<target name="i18n:download">
  <smartlingDownload filePattern="path/to/i18n/{{locale}}.json"
    fileUri="/Phing-Smartling/messages.json"
    includeOriginalStrings="false"
    locales="es-ES,fr-FR,ja-JP,zh-CN"
    projectId="FooBar"
    retrievalType="published"
    userId="MyUserIdentifier"
    userSecret="MyTokenSecret"
  />
</target>
```

#### Upload the message source to the Smartling service
This task takes a file path as input, specifying the message source to be uploaded.

```xml
<taskdef classname="phing\smartling\tasks\UploadTask" name="smartlingUpload"/>

<target name="i18n:upload">
  <smartlingUpload file="path/to/i18n/en-US.json"
    authorize="false"
    fileType="json"
    fileUri="/Phing-Smartling/messages.json"
    projectId="FooBar"
    userId="MyUserIdentifier"
    userSecret="MyTokenSecret"
  />
</target>
```

## See Also
- [Code Quality](https://www.codacy.com/app/aquafadas/phing-smartling)
- [Continuous Integration](https://travis-ci.org/aquafadas-com/phing-smartling)

A full sample is located in the `example` folder:  
[Sample Phing Tasks](https://github.com/aquafadas-com/phing-smartling/blob/master/example/build.xml)

## License
[Phing-Smartling](https://packagist.org/packages/aquafadas/phing-smartling) is distributed under the Apache License, version 2.0.
