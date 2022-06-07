<template><div>
	<div class="q-py-sm q-px-md">
		<q-input dense rounded standout="bg-yellow-8 text-white" v-model="search" color="yellow-8" placeholder="搜索">
			<template v-slot:prepend>
          		<q-icon name="o_search" />
       	 	</template>
			<template v-slot:after>
          		<q-btn v-if="!searchover" round dense flat icon="o_graphic_eq" @click="getSearch"/>
          		<q-btn v-else round dense flat icon="o_close" @click="exitSearch"/>
        	</template>
		</q-input>
	</div>
	<div class="q-px-md">
		<q-infinite-scroll @load="onLoad" :offset="200" v-if="!searchmode">

			<div v-for="item,index in teams" :key="index">
				<q-separator v-if="index!=0"/>
				<q-item dense class="bg-white q-px-xs rounded-borders q-py-sm" clickable @click="$refs.diateam.showPanel(item)">
					<q-item-section avatar >
						<q-img class="rounded-borders" :src="item.headimg" style="width:80px" :ratio="16/9"/>
					</q-item-section>
					<q-item-section class="text-left">
						<q-item-label :lines="1" class="text-body1 row items-center">{{item.name}}<q-chip class="q-ma-none q-ml-xs" square dark dense size="12px" :label="item.city" color="yellow-8"/></q-item-label>
						<q-item-label :lines="1" caption class="row items-center">
							<q-icon name="o_mood" size="14px"/>{{item.sum}} 
							<q-icon class="q-ml-sm" name="o_access_time" size="14px"/>{{df(item.create_time)}}
							<q-icon v-if="item.own" class="q-ml-sm" name="o_lock" size="14px"/>
						</q-item-label>
					</q-item-section>
				</q-item>
			</div>
			<template v-slot:loading>
		        <div class="row justify-center q-my-md">
		          	<q-spinner-dots v-if="!nullitem" color="yellow-8" size="24px" />
		          	<div v-else class="text-center text-grey text-caption">没有更多代表团</div>
		        </div>
		    </template>
		</q-infinite-scroll>
		<div v-if="searchmode">
			<div v-for="item,index in teams" :key="index">
				<q-separator v-if="index!=0"/>
				<q-item dense class="bg-white q-px-xs rounded-borders q-py-sm" clickable @click="$refs.diateam.showPanel(item)">
					<q-item-section avatar >
						<q-img class="rounded-borders" :src="item.headimg" style="width:80px" :ratio="16/9"/>
					</q-item-section>
					<q-item-section class="text-left">
						<q-item-label :lines="1" class="text-body1 row items-center">{{item.name}}<q-chip class="q-ma-none q-ml-xs" square dark dense size="12px" :label="item.city" color="yellow-8"/></q-item-label>
						<q-item-label :lines="1" caption class="row items-center">
							<q-icon name="o_mood" size="14px"/>{{item.sum}} 
							<q-icon class="q-ml-sm" name="o_access_time" size="14px"/>{{df(item.create_time)}}
							<q-icon v-if="item.own" class="q-ml-sm" name="o_lock" size="14px"/>
						</q-item-label>
					</q-item-section>
				</q-item>
			</div>
			<div v-if="teams.length<1" class="q-pa-lg text-caption text-grey text-center">未搜索到代表团</div>
		</div>
	</div>
	<diateam ref="diateam" @change=""/>
</div></template>
<script>
import diateam from '@/components/dialog/diateam'
export default{
name:'teamlist',
components:{diateam},
data(){return {
	show:false,nullitem:false,teams:[],index:1,
	search:'',searchover:false,searchmode:false,teamsback:[],
}},
mounted(){},
methods:{
	onLoad(index, done){
		this.index = index
		this.axios.get('teams',{params:{page:index,search:this.search}}).then(res=>{
			if(res.length>=10){
				this.teams.push(...res)
				done()
			}else if(res.length>0){
				this.teams.push(...res)
				this.nullitem = true
			}else{
				this.nullitem = true
			}
		})
	},
	getSearch(){
		if(!this.search){
			this.AItip('请输入搜索代表团名称',1)
			return
		}
		this.axios.get('teams',{params:{page:1,search:this.search}}).then(res=>{
			this.teams = Object.assign([],[],res)
			this.searchmode = true
			this.searchover = true
		})
	},
	exitSearch(){
		this.teams = []
		this.search = ''
		this.searchmode = false
		this.searchover = false
	}
},
watch:{
	'search'(){
		this.searchover = false
	}
},
destroy(){},
}
</script>
<style scoped>
.yfshadow{box-shadow:0.5px 1px 3px #CECECE,-0.5px -0.5px 3px #CECECE;}
</style>