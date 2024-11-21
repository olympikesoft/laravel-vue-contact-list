<template>
    <v-container>
        <v-card>
            <v-card-title class="d-flex flex-wrap align-items-center">
                <v-breadcrumb divider="mdi-chevron-right" class="flex-grow-1">
                    <v-breadcrumb-item :disabled="true">
                        {{ isEditing ? "Edit Contact" : "Add Contact" }}
                    </v-breadcrumb-item>
                </v-breadcrumb>

                <v-btn
                    color="secondary"
                    @click="goBack"
                    outlined
                    class="mt-2 mt-md-0"
                >
                    <v-icon left>mdi-chevron-left</v-icon>
                    Back
                </v-btn>
            </v-card-title>
            <v-alert v-if="error" type="error" outlined class="mb-4">
                {{ error }}
            </v-alert>
            <v-card-text>
                <v-form
                    ref="form"
                    v-model="isFormValid"
                    @submit.prevent="submitForm"
                >
                    <v-text-field
                        v-model="contact.name"
                        label="Name"
                        :rules="[rules.required]"
                        :error-messages="errors.name"
                        required
                        class="mb-4"
                    ></v-text-field>

                    <v-text-field
                        v-model="contact.email"
                        label="Email"
                        type="email"
                        :rules="[rules.required, rules.email]"
                        :error-messages="errors.email"
                        :readonly="isEditing"
                        required
                        class="mb-4"
                    ></v-text-field>

                    <v-text-field
                        v-model="contact.phone"
                        label="Phone"
                        :rules="[rules.required, rules.phone]"
                        :error-messages="errors.phone"
                        required
                        class="mb-4"
                    ></v-text-field>

                    <v-btn
                        :disabled="!isFormValid"
                        type="submit"
                        color="primary"
                        class="mt-4"
                    >
                        <v-icon left>mdi-check</v-icon>
                        Save
                    </v-btn>
                </v-form>
            </v-card-text>
        </v-card>
        <v-snackbar v-model="snackbar.show" :color="snackbar.color" top>
            <div class="text-subtitle-1 pb-2">{{ snackbar.text }}</div>
            <template #actions>
                <v-btn color="white" text @click="snackbar.show = false">
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            contact: { name: "", email: "", phone: "" },
            isEditing: false,
            isFormValid: false,
            rules: {
                required: (value) => !!value || "This field is required",
                email: (value) =>
                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(value) ||
                    "Invalid email address",
                phone: (value) =>
                    /^\d{10}$/.test(value) || "Phone number must be 10 digits",
            },
            errors: {},
            snackbar: {
                show: false,
                text: "",
                color: "success",
            },
            error: null,
        };
    },
    watch: {
        "contact.name"(newValue) {
            if (this.errors.name) this.errors.name = null;
        },
        "contact.email"(newValue) {
            if (this.errors.email) this.errors.email = null;
        },
        "contact.phone"(newValue) {
            if (this.errors.phone) this.errors.phone = null;
        },
    },
    methods: {
        showSnackbar(message, color = "success") {
            this.snackbar = {
                show: true,
                text: message,
                color: color,
            };
        },
        async submitForm() {
            this.errors = {};

            try {
                const endpoint = this.isEditing
                    ? `/api/contacts/${this.$route.params.id}`
                    : "/api/contacts";
                const method = this.isEditing ? "put" : "post";

                const response = await axios[method](endpoint, this.contact);

                if (
                    (this.isEditing && response.status === 200) ||
                    (!this.isEditing && response.status === 201)
                ) {
                    const message = this.isEditing
                        ? "Contact updated successfully."
                        : "Contact created successfully.";
                    this.showSnackbar(message);
                //    this.$router.push("/");
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    this.showSnackbar(
                        "Please correct the errors and try again.",
                        "error"
                    );
                } else {
                    console.error("Unexpected error:", error);
                    this.showSnackbar(
                        "An unexpected error occurred. Please try again.",
                        "error"
                    );
                }
            }
        },

        async fetchContact() {
            try {
                if (this.$route.params.id) {
                    const response = await axios.get(
                        `/api/contacts/${this.$route.params.id}`
                    );
                    this.contact = response.data;
                    this.isEditing = true;
                }
            } catch (error) {
                console.error("Error fetching contact:", error);
                this.showSnackbar("Failed to fetch contact details.", "error");
            }
        },

        goBack() {
            this.$router.push("/");
        },
    },
    mounted() {
        this.fetchContact();
    },
};
</script>
