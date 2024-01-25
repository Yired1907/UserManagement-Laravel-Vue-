<script setup>
import axios from "axios";
import { ref, onMounted, reactive } from "vue";
import { Form } from "vee-validate";
import { Field } from "vee-validate";
import * as yup from "yup";

let users = ref([]);

const form = reactive({
    name: "",
    email: "",
    password: "",
});

const getUsers = () => {
    axios.get("/api/users").then((response) => {
        users.value = response.data;
        // console.log(users);
    });
};

const schema = yup.object().shape({
    name: yup.string().required().label("Name"),
    email: yup.string().email().required().label("Email"),
    password: yup.string().required().min(8).label("Password"),
});

const createUser = (values, { resetForm }) => {
    axios.post("/api/users", values).then((response) => {
        users.value.unshift(response.data);
        $("#createUserModal").modal("hide");
        resetForm();
    });
};

// const createUser = () => {
//     axios.post("/api/users", form).then((response) => {
//         // users.value.push(response.data);
//         users.value.unshift(response.data);

//         form.name = "";
//         form.email = "";
//         form.password = "";
//         $("#createUserModal").modal("hide");
//     });
// };

onMounted(() => {
    getUsers();
});
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">List User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Starter Page</li>
                    </ol>
                </div>
            </div>

            <!-- Modal -->
            <button
                type="button"
                class="btn btn-success"
                data-toggle="modal"
                data-target="#createUserModal"
            >
                Add New User
            </button>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <th>{{ index + 1 }}</th>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <Form @submit="createUser" :validation-schema="schema" v-slot="{ errors }">
        <div class="modal fade" id="createUserModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Default Modal</h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <Field
                                name="name"
                                type="name"
                                class="form-control"
                                :class="{ 'is-invalid': errors.name }"
                                id="name"
                                placeholder="Name User"
                            />
                            <span class="invalid-feedback">{{
                                errors.name
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <Field
                                type="email"
                                class="form-control"
                                id="email"
                                placeholder="Email User"
                                name="email"
                                autocomplete="username"
                            />
                            <span class="invalid-feedback">{{
                                errors.email
                            }}</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <Field
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Password User"
                                name="password"
                                autocomplete="current-password"
                            />
                            <span class="invalid-feedback">
                                {{ errors.password }}
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button
                            type="button"
                            class="btn btn-default"
                            data-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Form>
</template>
