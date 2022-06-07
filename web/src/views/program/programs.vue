<template><div>
	<div v-if="show" class="q-pa-md">
		<div class="row items-start q-col-gutter-sm">
	    	<div class="col-6" v-for="item,index in programs">
		    	<q-item class="q-pa-none" style="overflow:hidden;" clickable @click="toProgram(item.pid)">
		    		<q-item-section>
		    			<q-img class="rounded-borders yshadow" :src="item.img" :ratio="2.2">
			    			<div class="absolute absolute-top-right" style="padding:0;background-color:transparent;">
			    				<q-chip class="q-ma-none" style="margin-top:-5px" :label="getSub(item.sid).name" dark dense square color="yellow-8"/>
			    			</div>
			    		</q-img>
		    			<q-item-label :lines="2" class="text-grey-8 q-pa-xs text-left">
		    				{{item.name}}
		    			</q-item-label>
		    		</q-item-section>
		    	</q-item>
		    </div>
	    </div>
	    <div v-if="programs.length<1" class="text-center text-caption text-grey q-py-lg">暂无竞赛</div>
	</div>

	<q-inner-loading :showing="!show">
    	<q-spinner-bars size="36px" color="yellow-8" />
    </q-inner-loading>
</div></template>
<script>
export default{
name:'programs',
props:['sid'],
components:{},
data(){return {
	programs:[],show:false,
}},
mounted(){
	this.getPrograms()
},
methods:{
	getPrograms(){
		this.axios.get('programs',{params:{sid:this.sid}}).then(res=>{
			this.programs = Object.assign([],[],res)
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