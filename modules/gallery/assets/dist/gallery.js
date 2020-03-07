var gallery = new Vue({
    el: "#gallery",
    data: {
        images: null,
        error: null,
        uploadInProgress: false,
    },
    created: function () {
        this.loadData();
    },
    methods: {
        deleteImage: function (id) {
            if (confirm("Are you sure?")) {
                var formData = new FormData();
                formData.append("image_id", id);
                formData.append(yii.getCsrfParam(), yii.getCsrfToken());

                this.$http.post(galleryDeleteUrl, formData).then(response => {
                    if (response.body.success == 1) {
                        this.loadData();
                    } else {
                        this.error = "Delete unsuccessful";
                    }
                }, response => {
                    this.error = "Delete unsuccessful";
                });
            }
        },
        rotateImage: function (id, degree) {
                var formData = new FormData();
                formData.append("image_id", id);
                formData.append("degree", degree);
                formData.append(yii.getCsrfParam(), yii.getCsrfToken());

                this.$http.post(galleryRotateUrl, formData).then(response => {
                    if (response.body.success == 1) {
                        this.loadData();
                    } else {
                        this.error = "Rotate unsuccessful";
                    }
                }, response => {
                    this.error = "Rotate unsuccessful";
                });
        },
        uploadImage: function (e) {
            var formData = new FormData();
            formData.append("KidImage[image]", e.target.files[0]);
            formData.append(yii.getCsrfParam(), yii.getCsrfToken());
            this.uploadInProgress = true;
            this.$http.post(galleryUploadUrl, formData).then(response => {
                if (response.body.success == 1) {
                    this.loadData();
                } else {
                    this.error = "Upload unsuccessful";
                }
                this.uploadInProgress = false;
            }, response => {
                this.error = "Upload unsuccessful";
                this.uploadInProgress = false;
            });
        },
        loadData: function () {
            this.$http.get(galleryImagesUrl).then((response) => {
                if (!!response.body) {
                    this.images = response.body;
                }
            }, (response) => {
                this.error = "Failed to load images";
            });
        }
    }
});