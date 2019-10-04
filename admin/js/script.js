function checkAllFields(opt){
	var ele = document.getElementsByName('delAnn[]');
	for(i=0;i<ele.length;i++){
		ele[i].checked=opt.checked
	}
}