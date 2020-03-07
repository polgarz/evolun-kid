var documents = new Vue({
    el: "#documents",
    data: {
        documents: null,
        form: {
            'name': '',
            'file': ''
        },
        errors: [],
        progress: false,
    },
    created: function () {
        this.loadData();
    },
    methods: {
        processFile(event) {
            this.form.file = event.target.files[0]
        },
        uploadDocument: function (event) {
            this.errors = [];
            this.progress = true;

            var formData = new FormData();
            formData.append("KidDocument[name]", this.form.name);
            formData.append("KidDocument[file]", this.form.file);
            formData.append(yii.getCsrfParam(), yii.getCsrfToken());

            this.$http.post(documentUploadUrl, formData).then(response => {
                if (response.body.success == 1) {
                    event.target.reset();
                    this.form.file = '';
                    this.form.name = '';
                    this.loadData();
                } else {
                    this.errors = response.body.error;
                }
                this.progress = false;
            }, response => {
                this.errors.push("Upload unsuccessful");
                this.progress = false;
            });
        },
        deleteDocument: function (event, id) {
            event.preventDefault();

            if (confirm("Are you sure?")) {
                var formData = new FormData();
                formData.append("document_id", id);
                formData.append(yii.getCsrfParam(), yii.getCsrfToken());

                this.$http.post(documentDeleteUrl, formData).then(response => {
                    if (response.body.success == 1) {
                        this.loadData();
                    } else {
                        this.errors.push("Delete unsuccessful");
                    }
                }, response => {
                    this.errors.push("Delete unsuccessful");
                });
            }
        },
        loadData: function () {
            this.errors = [];
            this.$http.get(documentListUrl).then((response) => {
                if (!!response.body) {
                    this.documents = response.body;
                }
            }, (response) => {
                this.errors.push("Failed to load documents");
            });
        }
    }
});