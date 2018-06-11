document.addEventListener("DOMContentLoaded", function () {
    var app = new Vue({
        el: '#root',
        data: function () {
            return {
                tasks: [],
                columns: [],
                newTask: {
                    title: "",
                    details: "",
                    type: 1
                },
                editingTask: null,
                queryText: ""
            }
        },
        created: function () {
            this.refreshColumns();
            this.refreshBoard();
        },
        methods: {
            refreshColumns: function () {
                var self = this;
                return fetch("/columns")
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (columns) {
                        self.columns = columns;
                    });
            },
            refreshBoard: function () {
                var self = this;
                return fetch("/task/all", {
                    method: "POST",
                    body: JSON.stringify({
                        query_text: self.queryText
                    })
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (tasks) {
                        self.tasks = tasks;
                    });
            },
            getColumnTasks: function (column) {
                return this.tasks.filter(function (task) {
                    return task.type === column.type;
                });
            },
            addNewTask: function () {
                var self = this;
                fetch("/task/add", {
                    method: "POST",
                    body: JSON.stringify(this.newTask)
                }).then(function () {
                    return self.refreshBoard();
                }).then(function () {
                    jQuery('#task_add_modal').modal('hide');
                });
            },
            getColumnTasksCount: function (column) {
                return (this.getColumnTasks(column).length || "0");
            },
            clickOnTask: function (task) {
                this.editingTask = task;
                Vue.nextTick(function () {
                    jQuery('#task_edit_modal').modal('show');
                })
            },
            editTask: function () {
                var self = this;
                fetch("/task/edit", {
                    method: "POST",
                    body: JSON.stringify(self.editingTask),
                }).then(function () {
                    return self.refreshBoard();
                }).then(function () {
                    jQuery('#task_edit_modal').modal('hide');
                });
            },
            deleteTask: function () {
                var self = this;
                fetch("/task/delete", {
                    method: "POST",
                    body: JSON.stringify({
                        task_id: self.editingTask.task_id
                    }),
                }).then(function () {
                    return self.refreshBoard();
                }).then(function () {
                    jQuery('#task_edit_modal').modal('hide');
                });
            },
            formatDate: function (datetime) {
                var d = new Date(datetime.date);
                return d.getFullYear()
                    + "-" + ("0" + (d.getMonth() + 1)).slice(-2)
                    + "-" + ("0" + d.getDate()).slice(-2)
                    + " " + ("0" + d.getHours()).slice(-2)
                    + ":" + ("0" + d.getMinutes()).slice(-2);
            },
        }
    });
});
