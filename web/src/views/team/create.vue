<template><div>
	<div v-if="show">
		<div style="position:absolute;z-index:-1;height:200px;width:100%;" class="bg-yellow-8"></div>
		<upload1 style="height:200px;width:100%;box-shadow:inset 0px -1px 8px #9B9B9B;" :img.sync="team.headimg"/>
		<div class="q-pa-lg">
			<div v-if="disable" class="row items-center yfinput q-mb-sm justify-center">
				<q-icon :name="disable&&team.thid?'not_listed_location':'beenhere'" size="22px" class="q-mr-sm" :color="disable&&team.thid?'yellow-8':'green-4'"/>
				<div class="text-subtitle1">{{team.thid?'正在审核中':'审核已通过'}}</div>
			</div>
			<q-input :readonly="$store.state.loading||disable" :filled="!disable" :maxlength="20" class="yfinput q-mb-md" v-model="team.name" dense color="yellow-8">
				<template v-slot:prepend>
					<div class="text-body2 wl1">名称：</div>
				</template>
			</q-input>
			<q-select :readonly="$store.state.loading||disable" :filled="!disable" class="yfinput q-mb-md" v-model="team.city" dense color="yellow-8" :options="citys">
				<template v-slot:prepend>
					<div class="text-body2 wl1">地市州：</div>
				</template>
			</q-select>
			<q-item tag="label" v-ripple :class="['yfinput q-mb-md bg-grey-2']">
	        	<q-item-section class="text-left">
	          		<q-item-label>{{team.own?'私有':'公开'}}</q-item-label>
	          		<q-item-label :lines="1" caption>{{team.own?'输入邀请码加入':'任何人可直接加入'}}</q-item-label>
	        	</q-item-section>
	        	<q-item-section avatar>
	          		<q-toggle :disable="$store.state.loading||disable" color="yellow-8" :true-value="1" :false-value="0" v-model="team.own"/>
	        	</q-item-section>
	      	</q-item>
	      	<q-input v-if="team.own" :readonly="$store.state.loading||disable" :filled="!disable" :maxlength="6" class="yfinput q-mb-md" v-model="team.code" dense color="yellow-8" unmasked-value mask="######">
				<template v-slot:prepend>
					<div class="text-body2 wl1">邀请码：</div>
				</template>
			</q-input>
			<q-btn v-if="!disable" :loading="$store.state.loading" class="full-width yfinput" label="创建代表团" color="yellow-8" @click="$refs.diaauth1.showPanel('一个用户只能创建一个代表团')"/>
			<q-btn v-if="disable&&team.thid" :loading="$store.state.loading" class="full-width yfinput" outline label="取消创建" color="red-8" @click="$refs.diaauth2.showPanel('您确定要取消创建吗？')"/>
		</div>
	</div>
	<q-inner-loading :showing="!show">
    	<q-spinner-bars size="36px" color="yellow-8" />
    </q-inner-loading>

	<diaauth v-if="show" ref="diaauth1" @change="addTeam"/>
	<diaauth v-if="show" ref="diaauth2" @change="deleteTeam"/>
</div></template>
<script>
import upload1 from '@/components/upload1'
import diaauth from '@/components/dialog/diaauth'
export default{
name:'create',
props:[],
components:{upload1,diaauth},
data(){return {
	show:false,disable:false,
	initteam:{name:'',city:'',headimg:'',own:0,code:''},
	team:{name:'',city:'',headimg:'',own:0,code:''},
	citys:['四川','成都','自贡','攀枝花','泸州','德阳','绵阳','广元','遂宁','内江','乐山','南充','宜宾','广安','达州','巴中','雅安','眉山','资阳','阿坝','甘孜','凉山'],
}},
mounted(){
	this.getData()
},
methods:{
	getData(){
		this.axios.get('createteam').then(res=>{
			if(res.name){
				this.team = Object.assign({},{},res)
				this.disable = true
			}else{
				this.team = Object.assign({},{},this.initteam)
				this.disable = false
			}
			this.show = true
		})
	},
	addTeam(){
		this.axios.post('addTeam',this.team).then(res=>{
			this.getData()
		})
	},
	deleteTeam(){
		this.axios.post('deleteTeam').then(res=>{
			this.getData()
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>
.yfinput{max-width:280px;margin-left:auto;margin-right:auto;}
.wl1{width:72px;}
</style>