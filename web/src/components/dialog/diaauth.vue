<template>
	<q-dialog v-model="show" @hide="hidePanel">
		<q-card class="shadow-2">
			<q-card-section class="text-subtitle1">
				<div class="text-bold text-center">
					{{text}}
				</div>
				<div class="text-center">{{intro}}</div>
			</q-card-section>
			<q-card-actions align="between" class="q-pa-none" >
				<q-btn label flat label="取消" class="col" @click="hidePanel"/>
				<q-btn label flat label="提交" class="col" @click="submit"/>
			</q-card-actions>
		</q-card>
	</q-dialog>
</template>
<script>
export default{
name:'diaauth',
props:[],
components:{},
data(){return {
	show:false,text:'',intro:'',
}},
mounted(){},
methods:{
	showPanel(text='',intro=''){
		if(intro){
			this.intro = intro
		}else{
			this.intro = '请注意填写信息是否正确'
		}
		this.text = text
		this.show = true
	},
	hidePanel(){
		this.show = false
	},
	submit(){
		this.$emit('change')
		this.hidePanel()
	}
},
watch:{},
destroy(){},
}
</script>
<style scoped>

</style>