<template><div class="q-py-sm q-px-md">
<div v-if="show">
	<q-carousel v-model="slide" transition-prev="scale" transition-next="scale" height="41vw" style="max-height:180px"
        swipeable animated control-color="white" arrows autoplay infinite class="bg-yellow-8 yshadow text-white rounded-borders q-mb-md"
    >
        <q-carousel-slide v-for="item,index in tops" :name="index" :img-src="item.img" @click="goUrl(item.url)"/>
    </q-carousel>

    <div class="row items-center">
    	<q-btn class="col-3" unelevated v-for="item,index in $store.state.subjects" @click="$router.push('programs/'+item.sid)">
    		<q-img class="rounded-borders yshadow" style="width:80%" :ratio="1" :src="item.headimg"/>
    		<div class="text-grey-7 full-width" style="white-space:nowrap;">{{item.name}}</div>
    	</q-btn>
    </div>
    <div class="row items-center q-my-sm text-left text-bold">
    	<div class="bg-yellow-8 q-mr-xs" style="width:3px;height:18px"></div>
    	<div class="bg-blue-2 q-mr-xs" style="width:3px;height:18px"></div>
    	<div class="text-subtitle1">近期活动</div>
    	<q-space/>
    	<div class="text-caption text-grey" @click="$router.push('programs/0')">更多<q-icon name="o_keyboard_arrow_right" size="14px"/></div>
    </div>
	
    <div class="row items-start q-col-gutter-sm">

    	<div class="col-6" v-for="item,index in programs">
	    	<q-item class="q-pa-none" style="overflow:hidden;" clickable @click="toProgram(item.pid)">
	    		<q-item-section>
	    			<q-img class="rounded-borders yshadow" :src="item.img" :ratio="2.2">
		    			<div class="absolute absolute-top-right" style="padding:0;background-color:transparent;">
		    				<q-chip class="q-ma-none" style="margin-top:-5px" :label="getSub(item.sid).name" dark dense square color="yellow-8"/>
		    			</div>
		    		</q-img>
	    			<q-item-label :lines="2" class="text-grey-8 q-pa-xs">
	    				{{item.name}}
	    			</q-item-label>
	    		</q-item-section>
	    	</q-item>
	    </div>
    </div>
</div>
<q-inner-loading :showing="!show">
    <q-spinner-bars size="36px" color="yellow-8" />
</q-inner-loading>
</div></template>
<script>
export default{
name:'vue',
components:{},
data(){return {
	show:false,slide:0,tops:[],programs:[]
}},
mounted(){
    this.getData()
},
methods:{
    getData(){
        this.axios.get('home').then(res=>{
            this.$store.state.subjects = this.$store.state.subjects.length>0 ? this.$store.state.subjects : Object.assign([],[],res.subjects)
            this.programs = Object.assign([],[],res.programs)
            this.tops = Object.assign([],[],res.tops)
            this.show = true
        })
    },
	toProgram(pid){
		this.$router.push('/program/'+pid)
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>