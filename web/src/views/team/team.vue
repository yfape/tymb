<template><div>

	<div v-if="show">
		<div style="box-shadow:inset 0px -1px 8px #9B9B9B;height:200px;"><q-img style="position:relative;z-index:-1;" class="full-height" :ratio="16/9" :src="team.headimg" /></div>
		<div class="text-left q-px-md q-pt-md row items-center">
			<q-chip dense dark color="yellow-8" :label="team.city" square/>
			<div class="text-subtitle1 q-ml-xs">{{team.name}}</div>
		</div>
		<div class="text-caption q-px-md text-grey text-left row items-center ">
			<div>代表团人数:{{team.sum}}人</div>
			<div class="q-pl-md">创建时间:{{df(team.create_time)}}</div>
			<div v-if="team.own==0||team.own==1" class="col-12">
				开放状态:{{team.own?'私有':'公开'}}
				<span v-if="team.own==1&&team.code" class="q-ml-sm">邀请码:{{team.code}}</span>
			</div>
			
		</div>

		<div class="row items-center q-mt-sm q-mb-md">
			<div class="col-8 q-pl-md q-pr-sm">
				<q-btn dense class="full-width" color="yellow-8" icon="o_reorder" label="代表团列表" @click="$router.push('/teamlist')"/>
			</div>
			<div class="col-4 q-pl-sm q-pr-md">
				<q-btn dense class="full-width" color="red-8" label="退出代表团" @click="$refs.diaauth.showPanel('您确定要退出代表团吗',team.name)"/>
			</div>
		</div>

		<div v-if="team.valid" class="q-px-md">
			<div class="text-left"><span class="text-yellow-8">|</span><span class="text-blue-2">|</span> 代表团成员</div>
			<q-infinite-scroll @load="onLoad" :offset="0">
				<div class="row q-py-sm q-col-gutter-sm">
					<div v-for="item,index in member" class="col-6" :key="index"><q-item dense class="bg-grey-2 q-pa-xs rounded-borders">
						<q-item-section avatar >
							<q-img class="rounded-borders" :src="item.wx.headimgurl" :ratio="1"/>
						</q-item-section>
						<q-item-section class="text-left">
							<q-item-label :lines="1" >{{item.wx.nickname}}</q-item-label>
							<q-item-label :lines="2" caption>
								{{item.wx.city}}
							</q-item-label>
						</q-item-section>
					</q-item></div>
				</div>
				<template v-slot:loading>
			        <div class="row justify-center q-my-md">
			          	<q-spinner-dots v-if="!nullitem" color="yellow-8" size="24px" />
			          	<div v-else class="text-center text-grey text-caption">没有更多成员</div>
			        </div>
			    </template>
			</q-infinite-scroll>
		</div>
		<div v-else class="q-pt-xl text-grey text-subtitle1">
			代表团已被禁用
		</div>
	</div>

	<q-inner-loading :showing="!show">
    	<q-spinner-bars size="36px" color="yellow-8" />
    </q-inner-loading>

    <diaauth ref="diaauth" @change="exitTeam"/>
</div></template>
<script>
import diaauth from '@/components/dialog/diaauth'
export default{
name:'team',
components:{diaauth},
data(){return {
	show:false,team:{},member:[],nullitem:false,
}},
mounted(){
	this.getTeam()
},
methods:{
	getTeam(){
		this.axios.get('selfteam').then(res=>{
			if(!res||res.length==0){
				this.$router.push('/noteam')
			}
			this.team = Object.assign({},{},res)
			this.show = true
		})
	},
	onLoad(index, done){
		this.axios.get('members',{params:{page:index}}).then(res=>{
			if(res.length>=10){
				this.member.push(...res)
				done()
			}else if(res.length>0){
				this.member.push(...res)
				this.nullitem = true
			}else{
				this.nullitem = true
			}
		})
	},
	exitTeam(){
		this.axios.post('exitteam').then(res=>{
			this.$router.replace('/noteam')
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>