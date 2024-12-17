<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <!-- Client Info -->
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">Name</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Email</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Phone</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">Address</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bookings and Journals Tabs -->
            <div class="w-2/3">
                <div>
                    <button
                        class="btn"
                        :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}"
                        @click="switchTab('bookings')"
                    >
                        Bookings
                    </button>
                    <button
                        class="btn"
                        :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}"
                        @click="switchTab('journals')"
                    >
                        Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

                    <!-- Dropdown Filter -->
                    <div class="form-group mb-3">
                        <label for="filter">Filter Bookings:</label>
                        <select id="filter" class="form-control" v-model="currentFilter" @change="fetchBookings">
                            <option value="all">All bookings</option>
                            <option value="future">Future bookings</option>
                            <option value="past">Past bookings</option>
                        </select>
                    </div>

                    <template v-if="bookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookings" :key="booking.id">
                                    <td>{{ formatBookingTime(booking) }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">No bookings found.</p>
                    </template>
                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>
                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            currentFilter: 'all',
            bookings: this.client.bookings,
        };
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        fetchBookings() {
            axios
                .get(`/clients/${this.client.id}?filter=${this.currentFilter}`)
                .then((response) => {
                    if (response.data && response.data.client) {
                        this.bookings = response.data.client.bookings;
                    } else {
                        this.bookings = [];
                    }
                })
                .catch((error) => {
                    console.error('Failed to fetch filtered bookings:', error);
                    this.bookings = [];
                });
        },

        formatBookingTime(booking) {
            const startDate = new Date(booking.start);
            const endDate = new Date(booking.end);

            const options = {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
            };

            const startFormatted = startDate.toLocaleDateString(undefined, options);
            const endFormatted = endDate.toLocaleTimeString(undefined, {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
            });

            return `${startFormatted} to ${endFormatted}`;
        },
    },
};
</script>

<style>
.text-danger {
    color: red;
    font-size: 0.875rem;
}
</style>
