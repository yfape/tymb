<template><div style="">
	<div v-if="show" class="q-pa-md">
		<q-infinite-scroll @load="onLoad" :offset="200">
			<div v-for="item,index in records" class="q-mb-md yshadow rounded-borders" style="overflow:hidden;">
				<q-img :src="item.program.img" :ratio="2.2">
					<div class="absolute absolute-bottom text-center" style="padding:3px 5px">{{item.program.name}}</div>
				</q-img>
				<q-item class="bg-white">
					<q-item-section>
						<q-item-label :lines="1" class="text-left">代表团:{{item.team.name}}</q-item-label>
						<q-item-label :lines="2" caption class="text-left">
							<span class="q-mr-sm">组别:{{item.group}}</span>
							<span class="q-mr-sm">时间:{{df(item.time)}}</span>
						</q-item-label>
					</q-item-section>
					<q-item-section avatar>
						<q-btn icon="military_tech" flat color="yellow-8" dense @click="openImg(item.card)"/>
					</q-item-section>
				</q-item>
			</div>
			<template v-slot:loading>
		        <div class="row justify-center q-my-md">
		          	<q-spinner-dots v-if="!nullitem" color="yellow-8" size="24px" />
		          	<div v-else class="text-center text-grey text-caption">没有更多记录</div>
		        </div>
		    </template>
		</q-infinite-scroll>
	</div>
</div></template>
<script>
export default{
name:'records',
components:{},
data(){return {
	records:[],nullitem:false,show:true
}},
mounted(){

},
methods:{
	onLoad(index, done){
		this.axios.get('records',{params:{page:index}}).then(res=>{
			if(!res){
				this.nullitem = true
			}else if(res.length<5){
				this.records.push(...res)
				this.nullitem = true
			}else{
				this.records.push(...res)
				done()
			}
		})
	},
	openImg(img){
		this.$q.dialog({
	        dark: true,
	        ok:false,
	        message: '<div style="width:100%;padding:0 8px;text-align:center"><img style="width:100%;" src="'+img+'"/></div>',
	        html: true
	      })
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>