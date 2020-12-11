<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <datatable :columns="columns" :data="rows"></datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        console.log('Component mounted.')
    },
    data() {
        return {
            columns: [
                {label: 'Offer ID', field: 'id'},
                {label: 'Name', field: 'name', headerClass: 'class-in-header second-class'},
                {label: 'Image URL', field: 'image_url'},
                {
                    label: 'Image',
                    representedAs: ({image_url}) => `<img src="${image_url}">`,
                    interpolate: true,
                },
                {
                    label: 'Cash Back',
                    representedAs: ({cash_back}) => `${this.formatCurrency(cash_back)}`,
                    interpolate: false,
                },
            ],
            rows: [
                //...
                {
                    "id": "40408",
                    "name": "Buy 2: Select TRISCUIT Crackers",
                    "image_url": "https://d3bx4ud3idzsqf.cloudfront.net/public/production/6840/67561_1535141624.jpg",
                    "cash_back": 100
                }
                //...
            ]
        }
    },
    methods: {
        formatCurrency(cents) {
            const formatter = new Intl.NumberFormat('en-CA', {
                style: 'currency',
                currency: 'CAD',
            });
            return formatter.format(cents / 100);
        },
    },
}
</script>
