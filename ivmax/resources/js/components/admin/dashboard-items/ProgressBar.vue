<template>
    <div class="progress-group">
        <span class="progress-text">{{title}}</span>
        <span class="progress-number" v-if="target && reach"><b>{{reach ? reach : ''}}</b>/{{target ? target : ''}}</span>

        <div class="progress sm">
            <div class="progress-bar" :class="barColor" :style="`width:${percent}%`"></div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            title: {
                type: String,
                default: '',
            },
            percent: {
                type: Number,
                default: 0,
            },
            target: {
                type: Number,
                default: null,
            },
            reach: {
                type: Number,
                default: null
            }
        },
        computed: {
            barColor: function(){
                if(this.color ){
                    return this.color;
                }
                if(this.percent < 25){
                    return 'bg-danger';
                }
                if(this.percent < 50){
                    return 'gb-warrning';
                }
                if(this.percent < 75){
                    return 'bg-primary';
                }
                return 'bg-success';
            }
        }
    }

</script>
