# Phing-Smartling
![Release](http://img.shields.io/npm/v/@aquafadas/phing-smartling.svg) ![License](http://img.shields.io/npm/l/@aquafadas/phing-smartling.svg) ![Downloads](http://img.shields.io/npm/dt/@aquafadas/phing-smartling.svg) ![Dependencies](http://img.shields.io/david/aquafadas-com/phing-smartling.svg) ![Code quality](https://img.shields.io/codacy/grade/a694355860834f91b2072e49b2825106.svg)

[Phing.js](http://phingjs.com) tasks dedicated to the synchronization of translations with the [Smartling](https://www.smartling.com) service, based on the [File API](http://docs.smartling.com/pages/API/v1/FileAPI).

## Getting Started
If you haven't used [Phing.js](http://phingjs.com) before, be sure to check out the [related documentation](https://github.com/phingjs/phing/blob/master/docs/README.md), as it explains how to create a `phingfile.js` as well as install and use plugins.
Once you're familiar with that process, you may install the provided Phing tasks with this command:

```shell
$ npm install --save-dev @aquafadas/phing-smartling
```

Once the build tasks have been installed, they may be enabled inside your `phingfile.js`.

## Tasks

#### Download the message translations from the Smartling service
This task takes a pattern as input, indicating the target path of the downloaded files.
The `${locale}` placeholder will be replaced by the locale of each file.

```javascript
const phing = require('phing');
const smartling = require('@aquafadas/phing-smartling');

phing.task('i18n:download', smartling.download('path/to/i18n/${locale}.json', {
  apiKey: 'MyApiKey',  // The Smartling API key.
  fileUri: '/Phing-Smartling/messages.json', // The file URL.
  locales: ['es', 'fr', 'ja', 'zh'], // The locales to be downloaded.
  projectId: 'FooBar' // The project identifier.
}));
```

The English language will be ignored by this task: this is the default locale used by the the message sources.

#### Upload the message source to the Smartling service
This task takes a path as input, specifying the message source to be uploaded.

```javascript
const phing = require('phing');
const smartling = require('@aquafadas/phing-smartling');

phing.task('i18n:upload', smartling.upload('path/to/i18n/en.json', {
  apiKey: 'MyApiKey', // The Smartling API key.
  fileType: 'json', // The file type: defaults to JSON.
  fileUri: '/Phing-Smartling/messages.json', // The file URL.
  projectId: 'FooBar' // The project identifier.
}));
```

The provided file must be in American English (e.g. the `en-US` locale), as suggested by the [Smartling](https://www.smartling.com) service.

## See Also
- [Code Quality](https://www.codacy.com/app/aquafadas/phing-smartling)

## License
[Phing-Smartling](https://github.com/aquafadas-com/phing-smartling) is distributed under the Apache License, version 2.0.
