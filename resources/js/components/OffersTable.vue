<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <datatable class="table-auto" :columns="columns" :data="fetchOffers" :per-page="perPage">
                            <template v-slot:footer="{ pagination }">
                                <tr>
                                    <td :colspan="2">
                                        <datatable-pager v-model="page"></datatable-pager>
                                    </td>
                                    <td :colspan="columns.length - 2">Showing rows {{pagination.from}} to {{pagination.to}} of {{pagination.of}} offers.</td>
                                </tr>
                            </template>
                        </datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
    },
    data() {
        return {
            columns: [
                {label: 'Offer ID', field: 'id'},
                {label: 'Name', field: 'name', headerClass: 'class-in-header second-class'},
                {
                    label: 'Image',
                    representedAs: ({image_url}) => `<img src="${image_url}">`,
                    interpolate: true,
                    sortable: false,
                },
                {
                    label: 'Cash Back',
                    field: 'cash_back',
                    representedAs: ({cash_back}) => `${this.formatCurrency(cash_back)}`,
                    interpolate: false,
                },
            ],
            rows: [],
            page: 1,
            perPage: 20,
        }
    },
    methods: {
        // Convert cents to dollars
        formatCurrency(cents) {
            const formatter = new Intl.NumberFormat('en-CA', {
                style: 'currency',
                currency: 'CAD',
            });
            return formatter.format(cents / 100);
        },
        // Retrieve list of offers
        async fetchOffers( { sortBy, sortDir, perPage, page }) {

            const apiQuery = "sortBy=" + encodeURIComponent(sortBy) + "&sortDir=" + encodeURIComponent(sortDir) + "&page=" + encodeURIComponent(page);

            const {
                // Data to display
                data,
            } = await axios.get( `/api/offers?${apiQuery}` );

            this.perPage = data.offers.per_page;

            return {
                rows:          data.offers.data,
                totalRowCount: data.offers.total,
            };
        },
    },
}
</script>
