window.addEventListener('load', () => {
	let buttons = [...document.querySelectorAll('a')]
	
	
	let slug = location.pathname.split('/').slice(1)[0] 
		
	console.log(slug)
	
	if(slug == 'cursos'){
		buttons.forEach((button) => {
			
		let href_old = button.href
			
		let href_new = href_old.replace(/(courses\/)|(groups\/)/, '');
			
		button.setAttribute('href', href_new)
		
		
		})
	}
	
})