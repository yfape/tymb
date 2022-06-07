<template><div>
	<div style="position:absolute;z-index:-1;height:100px;width:150%;border-radius:0 0 100% 0;box-shadow:inset -1px -1px 8px #9B9B9B;" class="bg-yellow-8"></div>
	<q-item style="height:100px" class="q-px-lg">
		<q-item-section avatar>
			<q-avatar size="48px" rounded>
		      	<img :src="$store.state.user.headimgurl">
		    </q-avatar>
		</q-item-section>
		<q-item-section>
			<q-item-label :lines="1" class="text-left text-subtitle1">
				<span class="q-mr-sm topfont">{{$store.state.user.nickname}}</span>
				<svg v-if="$store.state.user.sex==1" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 426.667 426.667" xml:space="preserve" width="15px" height="15px">
					<path style="fill:#50C8EF;" d="M165.705,426.667C74.334,426.667,0,352.333,0,260.962c0-91.366,74.334-165.7,165.705-165.7
							c91.366,0,165.7,74.334,165.7,165.7C331.405,352.333,257.071,426.667,165.705,426.667z M165.705,157.235
							c-57.199,0-103.735,46.532-103.735,103.731s46.532,103.735,103.735,103.735c57.195,0,103.735-46.532,103.735-103.735
							C269.436,203.767,222.899,157.235,165.705,157.235z"/>
					<polygon style="fill:#50C8EF;" points="426.667,165.705 364.698,165.705 364.698,61.969 260.962,61.969 260.962,0 426.667,0 	"/>
					<rect x="297.325" y="3.092" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 490.914 400.0457)" style="fill:#50C8EF;" width="61.968" height="190.518"/>
				</svg>
				<svg v-if="$store.state.user.sex==2" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="15px" width="15px" viewBox="0 0 417.606 417.606" style="enable-background:new 0 0 417.606 417.606;" xml:space="preserve">
					<path style="fill:#F05228;" d="M251.906,331.41c-91.379,0-165.709-74.338-165.709-165.705c0-91.371,74.334-165.705,165.709-165.705
						c91.366,0,165.7,74.334,165.7,165.705C417.606,257.072,343.272,331.41,251.906,331.41z M251.906,61.975
						c-57.203,0-103.735,46.532-103.735,103.735c0,57.195,46.532,103.735,103.735,103.735c57.199,0,103.735-46.537,103.735-103.735
						C355.637,108.507,309.105,61.975,251.906,61.975z"/>
					
						<rect x="58.314" y="233.078" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 -79.7284 623.65)" style="fill:#F05228;" width="61.968" height="190.518"/>
					
						<rect x="-5.991" y="297.329" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 -79.764 623.5881)" style="fill:#F05228;" width="190.518" height="61.968"/>
				</svg>
			</q-item-label>
			<q-item-label class="text-left text-caption text-white topfont">
				<span class="text-red-10 text-bold">{{$store.state.user.country}}</span>
				{{$store.state.user.province}}{{$store.state.user.city}}
			</q-item-label>
		</q-item-section>
		<q-item-section avatar>
			<q-chip square dense label="微信" outline style="color:#fff"/>
		</q-item-section>
	</q-item>

	<div v-if="show&&!formshow" class="wl" style="position:absolute;height:200px;width:100%;margin:auto;bottom:0;top:0;">
		<q-img src="image/null.png" :ratio="1.2" style="width:120px"/>
		<div class="q-pt-xs q-mb-lg tc2">无用户信息</div>
		<q-btn dense style="width:140px;background:#FECA50;color:#fff;" rounded label="开 始 填 写" @click="formshow=true"/>
	</div>

	<div v-if="show&&formshow" class="q-px-lg q-py-md text-center">

		<div class="q-mb-lg text-right text-bold text-body1">用户资料 <span class="text-blue-2">|</span><span class="text-yellow-8">|</span></div>

		<q-input :readonly="$store.state.loading" :maxlength="5" class="yfinput q-mb-md" v-model="userinfo.nickname" filled dense color="yellow-8">
			<template v-slot:prepend>
				<div class="text-body2 wl1">真实姓名</div>
			</template>
		</q-input>
		<q-input :readonly="$store.state.loading" class="yfinput" v-model="userinfo.idcard" filled dense color="yellow-8" unmasked-value mask="###### ######## ###X" no-error-icon :error-message="idcardhint" :error="idcardhint!=''" @blur="checkidcard">
			<template v-slot:prepend>
				<div class="text-body2 wl1">身份证</div>
			</template>
		</q-input>
		<q-input :readonly="$store.state.loading" class="yfinput q-mb-md" v-model="userinfo.phone" filled dense color="yellow-8" unmasked-value mask="###-####-####">
			<template v-slot:prepend>
				<div class="text-body2 wl1">电话号码</div>
			</template>
		</q-input>
		<q-item :disable="$store.state.loading" class="yfinput q-mb-md bg-grey-2" tag="label" v-ripple>
	        <q-item-section class="text-left">
	          	<q-item-label>是否为农民工?</q-item-label>
	          	<q-item-label caption>农民工请勾选</q-item-label>
	        </q-item-section>
	        <q-item-section avatar>
	          	<q-checkbox :disable="$store.state.loading" v-model="userinfo.ismigrant" color="yellow-8" :true-value="1" :false-value="0"/>
	        </q-item-section>
	    </q-item>
	    <q-btn v-if="!changeshow" :loading="$store.state.loading" class="full-width yfinput" label="提交用户资料" color="yellow-8" @click="$refs.diaauth.showPanel('参与活动时，用户资料会自动填入报名表')"/>
	    <q-btn v-else unelevated disable class="full-width yfinput text-grey-10" label="已 保 存" color="grey-3"/>
	</div>
	
	<q-inner-loading :showing="!show">
    	<q-spinner-bars size="36px" color="yellow-8" />
    </q-inner-loading>

    <diaauth ref="diaauth" @change="saveAuth"/>
</div></template>
<script>
import diaauth from '@/components/dialog/diaauth'
export default{
name:'auth',
props:[],
components:{diaauth},
data(){return {
	show:false,formshow:false,changeshow:false,
	idcardhint:'',
	userinfo:{},
	citys:['四川','成都','自贡','攀枝花','泸州','德阳','绵阳','广元','遂宁','内江','乐山','南充','宜宾','广安','达州','巴中','雅安','眉山','资阳','阿坝','甘孜','凉山'],
	inituserinfo:{uid:-1,nickname:'',idcard:'',phone:'',ismigrant:0},
}},
mounted(){
	this.getUser()
},
methods:{
	getUser(){
		this.axios.get('user').then(res=>{
			if(res){
				this.userinfo = Object.assign({},{},res)
				this.formshow = true
			}else{
				this.userinfo = Object.assign({},{},this.inituserinfo)
			}
			this.show = true
		})
	},
	checkidcard(){
		let res = this.IdCodeValid(this.userinfo.idcard)
		if(!res.pass){
			this.idcardhint = res.msg
		}else{
			this.idcardhint = ''
		}
	},
	saveAuth(){
		if(!this.judgeData()){
			this.AItip('输入信息不正确')
			return
		}

		let user = Object.assign({},{},this.userinfo)
		user.wx = Object.assign({},{},this.$store.state.user)

		this.axios.post('saveUser',user).then(res=>{
			this.userinfo = Object.assign({},{},res)
			this.$store.state.userinfo = Object.assign({},{},res)
			// this.lStorage('userinfo',res)
			this.changeshow = true
		})
	},
	judgeData(){
		let data = this.userinfo
		if(data.nickname!='' && data.idcard!='' && data.phone!='' && data.city!='' && data.team!='' && this.idcardhint==''){
			return true
		}else{
			return false
		}
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>
.topfont{text-shadow:1px 1.2px 1px #898987;color:#fff;}
.yfinput{max-width:280px;margin-left:auto;margin-right:auto;}
.wl1{width:72px;}
</style>