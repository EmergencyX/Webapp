<template>
  <input type="file" @change="changed" name="file">
</template>

<script>
  import tus from 'tus-js-client';

  export default {
    name: "uploader",
    methods: {
      changed: function (event) {
        const file = event.target.files[0];

        const upload = new tus.Upload(file, {
          endpoint: "http://localhost:8008/files/",
          retryDelays: [0, 1000, 3000, 5000],
          metadata: {
            filename: file.name,
            filetype: file.type,
            csrf: $('meta[name="csrf-token"]').attr('content'),
            token: window.tusToken
          },
          removeFingerprintOnSuccess: true,
          onError: function (error) {
            console.log("Failed because: " + error);
          },
          onProgress: function (bytesUploaded, bytesTotal) {
            const percentage = (bytesUploaded / bytesTotal * 100).toFixed(2);
            console.log(bytesUploaded, bytesTotal, percentage + "%");
          },
          onSuccess: function () {
            console.log("Download %s from %s", upload.file.name, upload.url);
          }
        });

        upload.start();
      }
    }
  }
</script>