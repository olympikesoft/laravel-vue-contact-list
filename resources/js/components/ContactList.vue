<template>
    <v-container>
        <v-card>
            <v-card-title>
                <span class="text-h5">Contact List</span>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="addContact"
                    >Add New Contact</v-btn
                >
            </v-card-title>
            <v-alert
            v-if="error"
            type="error"
            outlined
            class="mb-4"
            >
            {{ error }}
            </v-alert>
            <v-data-table
                :headers="headers"
                :items="contacts"
                item-value="id"
                class="elevation-1"
                @click:row="viewContact"
            >
                <template #item.actions="{ item }">
                    <v-btn
                        icon
                        color="primary"
                        @click.stop="editContact(item.id)"
                    >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn
                        icon
                        color="error"
                        @click.stop="deleteContact(item.id)"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            contacts: [],
            headers: [
                { text: "Name", value: "name" },
                { text: "Email", value: "email" },
                { text: "Phone", value: "phone" },
                { text: "Actions", value: "actions", sortable: false },
            ],
            error: null,
        };
    },
    methods: {
        async fetchContacts() {
            try {
                const response = await axios.get("/api/contacts");
                this.contacts = response.data;
                this.error = null; // Clear previous errors
            } catch (error) {
                this.error =
                    "Failed to fetch contacts. Please try again later.";
                console.error("Error fetching contacts:", error);
            }
        },
        viewContact(click, row) {
            if (row.item?.id) {
                this.$router.push(`/contacts/${row.item.id}`);
            } else {
                this.error =
                    "Contact is undefined or missing ID.";
                console.error("Contact is missing ID.");
            }
        },
        editContact(id) {
            this.$router.push(`/contacts/${id}/edit`);
        },
        async deleteContact(id) {
            if (id) {
                const confirmation = confirm(
                    "Are you sure you want to delete this contact?"
                );
                if (confirmation) {
                    try {
                        await axios.delete(`/api/contacts/${id}`);
                        console.log("Deleted contact with ID:", id);
                        this.fetchContacts();
                    } catch (error) {
                        this.error =
                       "Error deleting contact";
                        console.error("Error deleting contact:", error);
                    }
                }
            } else {
                console.error("Cannot delete contact: ID is undefined");
            }
        },
        addContact() {
            this.$router.push("/contacts/new");
        },
    },
    mounted() {
        this.fetchContacts();
    },
};
</script>
