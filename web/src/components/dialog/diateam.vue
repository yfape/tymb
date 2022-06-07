<template>
	<q-dialog v-model="show" @hide="hidePanel" position="bottom">
		<q-card class="shadow-2">
			<q-item>
				<q-item-section>
					<q-item-label :lines="1" class="text-bold text-subtitle1">{{team.name}} <q-chip class="q-ma-none q-ml-sm" square dark dense size="12px" :label="team.city" color="yellow-8"/></q-item-label>
					<q-item-label caption :lines="1" class="row items-center">
						<span class="text-bold">成员</span>:{{team.sum}}人 <span class="text-bold q-ml-sm">创建时间</span>:{{df(team.create_time)}}
					</q-item-label>
				</q-item-section>
				<q-item-section avatar >
					<q-img style="width:80px" class="rounded-borders shadow-2" :ratio="16/9" :src="team.headimg"/>
				</q-item-section>
			</q-item>
			<div class="q-pa-md">
				<div class="row items-center text-bold text-subtitle1">
					<span class="text-yellow-8">|</span><span class="text-blue-2 q-mr-sm">|</span>创建人
				</div>
				<div class="row items-center">
					<q-item class="bg-grey-2 col-6 q-pa-xs rounded-borders" v-if="creator">
						<q-item-section avatar>
							<q-img class="rounded-borders" :src="creator.headimgurl" :ratio="1"/>
						</q-item-section>
						<q-item-section >
							<q-item-label :lines="1" class="text-subtitle1">{{creator.nickname}}</q-item-label>
							<q-item-label :lines="1" caption>{{creator.city}}</q-item-label>
						</q-item-section>
					</q-item>
				</div>
			</div>
			<div class="q-pa-md">
				<q-btn class="full-width" rounded dense :loading="$store.state.loading" label="加入代表团" color="yellow-8" @click="joinTeam(0)"/>
			</div>

			<q-dialog v-model="inshow" persistent @hide="codehide">
				<q-card>
					<div class="text-center q-px-md q-py-sm">
						<div class="text-bold">{{team.name}}</div>
						<div class="">请输入邀请码</div>
						<q-input color="yellow-8" class="q-my-xs" dense filled v-model="code" label="邀请码" mask="######"/>
					</div>
					<div class="row items-center">
						<q-btn class="col-6" label="取消" flat v-close-popup/>
						<q-btn class="col-6" label="加入" flat @click="joinTeam(1)"/>
					</div>
				</q-card>
			</q-dialog>

		</q-card>
	</q-dialog>
</template>
<script>
export default{
name:'diaauth',
props:[],
components:{},
data(){return {
	show:false,team:{},creator:{},code:'',
	inshow:false,
}},
mounted(){},
methods:{
	showPanel(team){
		this.team = team
		this.getCreator()
		this.show = true
	},
	hidePanel(){
		this.show = false
	},
	getCreator(){
		this.axios.get('getCreator',{params:{tid:this.team.tid}}).then(res=>{
			this.creator = Object.assign({},{},res)
		})
	},
	codehide(){
		this.code = ''
		this.inshow = false
	},
	joinTeam(arg=0){
		if(this.team.own){
			if(arg==0){
				this.inshow = true
				return
			}else{
				if(!this.code){
					this.AItip('邀请码不能为空',1)
					return
				}
			}
		}
		this.inshow = false
		this.axios.post('joinTeam',{tid:this.team.tid,code:this.code}).then(res=>{
			this.$router.replace('/team')
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>