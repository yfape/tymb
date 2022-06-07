<template><div class="full-width full-height">
	<div style="height:100px;box-shadow:inset -1px -1px 8px #9B9B9B;" class="bg-yellow-8">
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
			<q-item-section avatar class="text-white text-subtitle1 text-bold" @click="$router.push('/auth')">
				>
			</q-item-section>
		</q-item>
	</div>
	<div class="bg-white q-py-sm">
		<div class="row items-center q-px-sm q-py-sm">
			<q-btn class="col-3" dense flat stack @click="$router.push('/auth')">
				<template v-slot:default>
					<q-icon name="how_to_reg" size="30px" color="orange-8"/>
					<div class="text-center text-caption">用户资料</div>
				</template>
			</q-btn>
			<q-btn class="col-3" dense flat stack @click="$router.push('/team')">
				<template v-slot:default>
					<q-icon name="flag" size="30px" color="red-8"/>
					<div class="text-center text-caption">代表团</div>
				</template>
			</q-btn>
			<q-btn class="col-3" dense flat stack @click="$router.push('/cards')">
				<q-icon name="military_tech" size="30px" color="yellow-8"/>
				<div class="text-center text-caption">证书</div>
			</q-btn>
			<q-btn class="col-3" dense flat stack @click="$router.push('/records')">
				<template v-slots:default>
					<q-icon name="sticky_note_2" size="30px" color="blue-7"/>
					<div class="text-center text-caption">参与记录</div>
				</template>
			</q-btn>
		</div>
		<q-item clickable class="" @click="goWXobj">
			<q-item-section>
				<q-item-label :line="1" class="text-left text-subtitle1">关注公众号</q-item-label>
			</q-item-section>
			<q-item-section>
				<q-item-label :line="1" class="text-right">
					<q-icon color="grey-5" size="18px" name="o_keyboard_arrow_right"/>
				</q-item-label>
			</q-item-section>
		</q-item>
		<q-separator inset/>
		<q-item clickable class="" @click="showNote">
			<q-item-section>
				<q-item-label :line="1" class="text-left text-subtitle1">分享</q-item-label>
			</q-item-section>
			<q-item-section>
				<q-item-label :line="1" class="text-right">
					<q-icon color="grey-5" size="18px" name="o_keyboard_arrow_right"/>
				</q-item-label>
			</q-item-section>
		</q-item>
	</div>
</div></template>
<script>

export default{
name:'user',
props:[],
components:{},
data(){return {

}},
mounted(){

},
methods:{
	goWXobj(){
		window.location.href = this.$store.state.system.wxnews
	},
	showNote(){
		this.$q.notify({
			message:'请点击右上角分享按钮',
			position:'center'
		})
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>
.topfont{text-shadow:1px 1.2px 1px #898987;color:#fff;}
</style>