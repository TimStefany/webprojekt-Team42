(function () {

    $(".dropzone").dropzone({
        url: 'https://mars.iuk.hdm-stuttgart.de/~ts170/pictures',
        margin: 20,
        params: {
            'action': 'save'
        },
        success: function (res, index) {
            console.log(res, index);
        }
    });

    $(".dropzone2").dropzone({
        url: 'https://mars.iuk.hdm-stuttgart.de/~ts170/pictures',
        margin: 20,
        allowedFileTypes: 'image.*, pdf',
        params: {
            'action': 'save'
        },
        uploadOnDrop: true,
        uploadOnPreview: false,
        success: function (res, index) {
            console.log(res, index);
        }
    });
}());