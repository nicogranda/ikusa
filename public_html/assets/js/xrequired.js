var business_card_price = 40;
var flyer_price = 50;
var poster_price = 60;
var banner_price = 100; 
var billboard_price = 300;
var post_price = 20;
var story_price = 20;
var reel_price = 100;
                
        function website_all(){
            if (document.getElementById('website').checked==true){
                document.getElementById('checkouta').style.display='block';
                
                document.getElementById('domain').checked=true;
                document.getElementById('hosting').checked=true;
                document.getElementById('development').checked=true;
                
                document.getElementById('domain_price').value=19.99;
                document.getElementById('hosting_price').value=143.88;
                document.getElementById('development_price').value=100;
                
            }   
            else {
                document.getElementById('checkouta').style.display='none';
              
                document.getElementById('domain').checked=false;
                document.getElementById('hosting').checked=false;
                document.getElementById('development').checked=false;
                
                document.getElementById('domain_price').value=0;
                document.getElementById('hostingv').value=0;
                document.getElementById('development_price').value=0;
                }
        }
        
        function graphic_desing_all(){
            if (document.getElementById('graphic_desing').checked==true){
          
                document.getElementById('checkoutb').style.display='block';
               
                document.getElementById('business_card').checked = true;
                document.getElementById('flyer').checked = true;
                document.getElementById('poster').checked = true;
                
                document.getElementById('banner').checked = true;
                document.getElementById('billboard').checked = true;
                     
                document.getElementById('post').checked = true;
                document.getElementById('story').checked = true;
                document.getElementById('reel').checked = true;
          
                document.getElementById('business_card_price').value = business_card_price;
                document.getElementById('flyer_price').value = flyer_price;
                document.getElementById('poster_price').value = poster_price;
                
                document.getElementById('banner_price').value= banner_price;
                document.getElementById('billboard_price').value = billboard_price;
                     
                document.getElementById('post_price').value = post_price;
                document.getElementById('story_price').value = story_price;
                document.getElementById('reel_price').value = reel_price;
              
            }   
            else {
                document.getElementById('checkoutb').style.display='none';
              
                document.getElementById('business_card').checked = false;
                document.getElementById('flyer').checked = false;
                document.getElementById('poster').checked = false;
                
                document.getElementById('banner').checked = false;
                document.getElementById('billboard').checked = false;
                     
                document.getElementById('post').checked = false;
                document.getElementById('story').checked = false;
                document.getElementById('reel').checked = false;
                
                document.getElementById('business_card_price').value = 0;
                document.getElementById('flyer_price').value = 0;
                document.getElementById('poster_price').value = 0;
                
                document.getElementById('banner_price').value= 0;
                document.getElementById('billboard_price').value = 0;
                     
                document.getElementById('post_price').value = 0;
                document.getElementById('story_price').value = 0;
                document.getElementById('reel_price').value = 0;
                }
        }

        function business_card_choose(){
            if (document.getElementById('business_card').checked == true){
		        document.getElementById('business_card_price').value = business_card_price;
            } else {
		        document.getElementById('business_card_price').value = 0;
            }    
        }

        function flyer_choose(){
            if (document.getElementById('flyer').checked == true){
		        document.getElementById('flyer_price').value = flyer_price;
            } else {

		        document.getElementById('flyer_price').value = 0;
            }    
        }

        function poster_choose(){
            if (document.getElementById('poster').checked == true){
		        document.getElementById('poster_price').value = poster_price;
            } else {

		        document.getElementById('poster_price').value = 0;
            }    
        }        

        function banner_choose(){
            if (document.getElementById('banner').checked == true){
		        document.getElementById('banner_price').value = banner_price;
            } else {

		        document.getElementById('banner_price').value = 0;
            }    
        }  
        
        function billboard_choose(){
            if (document.getElementById('billboard').checked == true){
		        document.getElementById('billboard_price').value = billboard_price;
            } else {

		        document.getElementById('billboard_price').value = 0;
            }    
        }  
        
        function post_choose(){
            if (document.getElementById('post').checked == true){
		        document.getElementById('post_price').value = post_price;
            } else {

		        document.getElementById('post_price').value = 0;
            }    
        }  
        
        function story_choose(){
            if (document.getElementById('story').checked == true){
		        document.getElementById('story_price').value = story_price;
            } else {

		        document.getElementById('story_price').value = 0;
            }    
        }  
        
        function reel_choose(){
            if (document.getElementById('reel').checked == true){
		        document.getElementById('reel_price').value = reel_price;
            } else {

		        document.getElementById('reel_price').value = 0;
            }    
        } 
        
        function online_stores(){
            if (document.getElementById('online_store').checked==true){
			    document.getElementById('online_store_products').style.display='block';
		        document.getElementById('online_store_price').value=250;
			   
            }
            else{
                document.getElementById('online_store_price').value=0;
                document.getElementById('online_store_products').style.display='none';
              
            }
        }
        

        
         function ecommercex(){
            if (document.getElementById('ecommerce').checked==true){
			    document.getElementById('ecommerce_products').style.display='block';
                document.getElementById('ecommercey').value=300;
            }
            else{
                document.getElementById('ecommercey').value=0;
                document.getElementById('ecommerce_products').style.display='none';
            }
        }
        
        function seo_add(){
            if (document.getElementById('seo').checked==true){
			    document.getElementById('seo_price').value = 600;
            }
            else {
                document.getElementById('seo_price').value=0;
               
            }    
        }
        
        function social_media_add(){
            if (document.getElementById('social_media').checked==true){
			    document.getElementById('social_media_price').value = 600;
            }
            else {
                document.getElementById('social_media_price').value=0;
               
            }    
        }
    
          function domainx(){
            if (document.getElementById('domain').checked==true){
			    document.getElementById('domain_price').value= 19.99;
            }
            else {
                document.getElementById('domain_price').value=0;
            }    
        }
        
          function hostingx(){
            if (document.getElementById('hosting').checked==true){
			    document.getElementById('hosting_price').value= 180;
            }
            else {
                document.getElementById('hosting_price').value=0;
            }    
        }
        
          
        function developex(){
            if (document.getElementById('development').checked==true){
			    document.getElementById('development_price').value=100;
            }
            else {
                document.getElementById('development_price').value=0;
            }    
        }
        
        function online_appointment_add(){
            if (document.getElementById('online_appointment').checked==true){
			    document.getElementById('online_appointment_price').value=300;
            }
            else {
                document.getElementById('online_appointment_price').value=0;
               
            }    
        }
        

        function idiom(){
            var wildcard=document.getElementById('wildcard').value;
          
            
            if (wildcard==1){ 
                document.getElementById('countrys').src = '../images/flag-02.png';
                document.getElementById('wildcard').value = 2;
                document.getElementById('spanishx').style.display = "none";
                document.getElementById('englishx').style.display = "block";
            }
            if (wildcard==2) {
                document.getElementById('countrys').src = '../images/flag-01.png';
                document.getElementById('wildcard').value = 1;
                document.getElementById('spanishx').style.display = "block";
                document.getElementById('englishx').style.display = "none";
            }
            
        }