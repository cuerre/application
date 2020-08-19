<template>
    <div class="my-4">
        <div class="row align-items-end rounded py-4">
            <div class="col-md-4 align-self-stretch">
                <select 
                    class="form-control form-control-sm mb-3 text-secondary h-100" 
                    :name="setTargetSystem()">

                    <option class="font-weight-bolder" selected>Choose a target</option>
                    <option value="win10">Windows 10</option>
                    <option value="android">Android</option>
                    <option value="ios">iOS</option>
                    <option value="any">Any</option>
                </select>
            </div>
            <div class="col-md align-self-stretch">
                <input 
                    type="text" 
                    class="form-control form-control-sm py-4 text-secondary" 
                    :name="setTargetUrl()" 
                    placeholder="http://goto.destination.com">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Codes target selector mounted.')
        },
        name: 'codes-target-selector',
        props: {
            name: String
        },
        methods: {
            setTargetSystem: function() {
                return "targets["+this.$props.name+"][system]";
            },
            setTargetUrl: function() {
                return "targets["+this.$props.name+"][url]";
            }
        }
    }
</script>
