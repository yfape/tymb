<template><div >
	<div v-if="show">
		<q-video v-if="program.video" :ratio="2.2" :src="program.video" />
		<q-img v-else :ratio="2.2" :src="program.img"/>
		<q-item class="q-py-md">
		<q-item-section>
			<q-item-label :lines="2" class="text-subtitle1 text-left">
				{{program.name}}
			</q-item-label>
			<q-item-label :line="1" class="text-left row items-center" caption>
				<span class="q-mr-sm">参与人数:{{program.sum}}</span>
				代表团:{{program.teamsum}}
			</q-item-label>
		</q-item-section>
		<q-item-section avatar>
			<q-img class="rounded-borders yshadow" :src="program.img" style="width:94px" :ratio="2.2"/>
		</q-item-section>
		</q-item>
	</div>
	<q-tab-panels v-if="show" v-model="tab" animated>
		<q-tab-panel :name="0" class="q-pa-none q-my-sm">
			<div class="q-mx-md col-12 row items-center rounded-borders" style="background-image:linear-gradient(to right,#F5F5F5,transparent);">
			    <div class="text-white bg-yellow-8 q-px-xs rounded-borders">开始时间</div>
			    <div class="text-caption q-ml-xs">{{dtf(program.start)}}</div>
			</div>
			<div class="q-mx-md q-mb-sm col-12 row items-center justify-end" style="background-image:linear-gradient(to left,#F5F5F5,transparent);">
			    <div class="text-caption q-mr-xs">{{dtf(program.end)}}</div>
			    <div class="text-white bg-blue-2 q-px-xs rounded-borders">结束时间</div>
			</div>

			<div class="q-py-sm q-px-md text-left">
				<div v-html="program.content"></div>
			</div>

			<div class="row items-center q-px-md q-my-sm text-left text-bold">
		    	<div class="bg-yellow-8 q-mr-xs" style="width:3px;height:18px"></div>
		    	<div class="bg-blue-2 q-mr-xs" style="width:3px;height:18px"></div>
		    	<div class="text-subtitle1">代表团排名</div>
		    	<q-space/>
		    	<!-- <div class="text-caption text-grey">更多<q-icon name="o_keyboard_arrow_right" size="14px"/></div> -->
		    </div>

		    <q-item v-for="item,index in teams" :class="[[index>=5?'bg-grey-2':''],]">
		    	<q-item-section avatar>
		    		<q-img class="rounded-borders yshadow" :ratio="16/9" :src="item.team.headimg" style="width:80px"/>
		    	</q-item-section>
		    	<q-item-section class="text-left">
		    		<q-item-label :lines="1">{{item.team.name}}</q-item-label>
		    		<q-item-label :lines="1" caption class="row items-center">
		    			<q-chip dark dense square color="yellow-8" size="12px" :label="item.team.city" class="q-py-none q-ma-none"/>
		    			<span class="q-ml-xs">参与人数:{{item.sum}}人</span>
		    		</q-item-label>
		    	</q-item-section>
		    	<q-item-section avatar class="text-yellow-8">
		    		{{index<=4?index+1:'第'+item.sort+'位'}}
		    	</q-item-section>
		    </q-item>
		    <div v-if="teams.length<1" class="text-center text-caption text-grey">未排名信息</div>

		    <div class="q-pa-md">
		    	<q-btn class="full-width" color="yellow-8" rounded label="立 即 参 加" dense v-if="program.start<time&&program.end>time" @click="join" :loading="$store.state.loading"/>
		    	<q-btn disable class="full-width" color="grey-5" rounded label="活动暂未开始" dense v-if="program.start>time"/>
		    	<q-btn disable class="full-width" color="grey-5" rounded label="已 结 束" dense v-if="program.end<time"/>
		    </div>
		</q-tab-panel>
		<q-tab-panel :name="1" class="q-pa-none q-px-md">
			<div class="q-mt-sm text-grey text-caption text-center">请选择您参加的组别</div>
			<q-btn-toggle class="q-mb-lg no-shadow yshadow" dense rounded uneleveted spread v-model="group" toggle-color="yellow-8" :options="groups"
		    />
			<div class="text-center text-caption text-grey">
				注:点击加号上传视频，视频不能超过100Mb
			</div>
			<div class="row items-center justify-center">
				<upload2 :video="video" @change="changeVideo"/>
				<span v-if="video" class="text-caption text-grey">已添加视频</span>
			</div>
			<div class="row q-my-md q-mt-lg items-center justify-center">
				<q-btn v-if="!video||!group" class="col-4" color="grey-5" outline rounded label="取 消" dense @click="tab=0"/>
				<q-btn v-else class="col-4" color="grey-5" flat rounded label="取 消" dense @click="tab=0"/>
		    	<q-btn class="col-8" color="yellow-8" rounded label="提 交" dense v-if="program.start<time&&program.end>time&&video&&group" @click="submit"/>
		    </div>
		</q-tab-panel>
		<q-tab-panel v-if="loading" :name="2" class="q-pa-none q-px-md row items-center" style="min-height:300px">
			<div class="text-caption text-grey text-center col-12">
				<q-spinner-hourglass color="yellow-8" size="28px"/><br>
				正在上传中，请耐心等待
			</div>
		</q-tab-panel>
		<q-tab-panel :name="3" v-if="joininfo.card">
			<div class="text-caption text-grey text-center q-mb-sm">您已经参与本次活动，下面是您的参与证书</div>
			<div>
				<q-img :src="joininfo.card" style="max-width:250px"/>
			</div>
			<div class="q-py-md"><q-btn style="width:200px" color="yellow-8" rounded label="返 回" dense @click="tab=0"/></div>
		</q-tab-panel>
	</q-tab-panels>
	<q-inner-loading :showing="!show">
    	<q-spinner-bars size="36px" color="yellow-8" />
    </q-inner-loading>
</div></template>
<script>
import upload2 from '@/components/upload2'
export default{
name:'program',
props:['pid'],
components:{upload2},
data(){return {
	show:false,time:0,tab:0,loading:false,
	program:{},
	teams:[],
	joininfo:{card:''},
	groups:[],
	video:'',group:'',
}},
mounted(){
	this.time = Date.parse(new Date())/1000
	this.getProgram()
},
methods:{
	getProgram(){
		this.axios.get('program',{params:{pid:this.pid}}).then(res=>{
			this.program = Object.assign({},{},res.program)
			this.teams = Object.assign([],[],res.teams)
			for(let i in this.program.groups){
				this.groups.push({label:this.program.groups[i],value:this.program.groups[i]})		
			}
			this.show = true
		})
	},
	changeVideo(video){
		this.video = video
	},
	submit(){
		this.loading = true
		this.tab = 2

		var param = new FormData();
		param.append('video',this.video)
		param.append('pid',this.program.pid)
		param.append('group',this.group)

		this.axios.post('joinProgram',param).then(res=>{
			this.loading = false
			this.joininfo.card = res.card
			this.saveCard(res.card)
			this.tab = 3
		})
	},
	saveCard(card){
		let join = {pid:this.pid,card:card,name:this.program.name}
		let cards = this.lStorage('cards')
		if(!cards){
			cards = []
		}
		cards.push(join)
		this.lStorage('cards',cards)
	},
	join(){
		this.axios.get('joinJudge',{params:{pid:this.pid}}).then(res=>{
			if(res.jid){
				this.joininfo = Object.assign({},{},res)
				this.tab = 3
			}else{
				this.tab = 1
			}
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>
.cys{max-width:300px;margin:0 auto;margin-bottom:8px}
</style>