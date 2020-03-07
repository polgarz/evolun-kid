Vue.component('paginate', VuejsPaginate);

var notes = new Vue({
    el: "#notes",
    data: {
        data: {
            items: [],
            pagination: {
                pageCount: 1,
            }
        },
        page: 1,
        form: {
            title: '',
            note: ''
        },
        errors: [],
    },
    created: function () {
        this.loadData();
    },
    methods: {
        loadData: function (page) {
            this.errors = [];
            this.$http.get(noteListUrl, {
                params: { page : page }
            }).then((response) => {
                if (!!response.body) {
                    this.data = response.body;
                }
            }, (response) => {
                this.errors.push("There was an error while tried to load notes");
            });
        },
        createNote: function (event) {
            this.errors = [];

            var formData = new FormData();
            formData.append("KidNote[title]", this.form.title);
            formData.append("KidNote[note]", this.form.note);
            formData.append(yii.getCsrfParam(), yii.getCsrfToken());

            this.$http.post(noteCreateUrl, formData).then(response => {
                if (response.body.success == 1) {
                    event.target.reset();
                    this.form.title = '';
                    this.form.note = '';
                    this.loadData();
                    this.page = 1;
                } else {
                    this.errors = response.body.error;
                }
            }, response => {
                this.errors.push("Publication failed");
            });
        },
        deleteNote: function (event, id) {
            event.preventDefault();

            if (confirm("Are you sure?")) {
                var formData = new FormData();
                formData.append("note_id", id);
                formData.append(yii.getCsrfParam(), yii.getCsrfToken());

                this.$http.post(noteDeleteUrl, formData).then(response => {
                    if (response.body.success == 1) {
                        this.loadData();
                        this.page = 1;
                    } else {
                        this.errors.push("Delete failed");
                    }
                }, response => {
                    this.errors.push("Delete failed");
                });
            }
        },
    }
});