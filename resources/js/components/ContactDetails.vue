<template>
    <v-container>
        <v-card>
            <v-card-title class="d-flex flex-wrap align-items-center">
                <v-breadcrumb divider="mdi-chevron-right" class="flex-grow-1">
                    <v-breadcrumb-item :disabled="true">
                        View Contact
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

            <!-- Contact Details -->
            <v-card-text>
                <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="contact.name"
                            label="Name"
                            readonly
                            class="mb-4"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="contact.email"
                            label="Email"
                            readonly
                            class="mb-4"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field
                            v-model="contact.phone"
                            label="Phone"
                            readonly
                            class="mb-4"
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            contact: { name: "", email: "", phone: "" },
        };
    },
    methods: {
        async fetchContact() {
            if (this.$route.params.id) {
                try {
                    const response = await axios.get(
                        `/api/contacts/${this.$route.params.id}`
                    );
                    this.contact = response.data;
                } catch (error) {
                    console.error("Error fetching contact:", error);
                }
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
