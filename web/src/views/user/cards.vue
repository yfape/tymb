<template><div class="q-pa-md">
	<div class="row items-start q-col-gutter-md">
		<div v-for="item in cards" class="col-6">
			<q-img class="yshadow rounded-borders" :src="item.card" contain />
			<div class="text-center text-caption text-grey">{{item.name}}</div>
		</div>
	</div>

	<div class="row items-center justify-center q-pt-lg">
		<div class="text-grey text-caption">证书有误？试一试</div><q-btn :loading="$store.state.loading" color="yellow-8" dense flat label="重新获取" @click="syncCards"/>
	</div>
	
	

</div></template>
<script>
export default{
name:'cards',
components:{},
data(){return {
	cards:[]
}},
mounted(){
	this.getCards()
},
methods:{
	getCards(){
		let cards = this.lStorage('cards')
		if(cards){
			this.cards = Object.assign([],[],cards)
		}
	},
	syncCards(){
		this.axios.get('cards').then(res=>{
			this.cards = Object.assign([],[],res)
			this.lStorage('cards',res)
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>