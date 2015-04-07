	// this is used for formatting metars/tafs for each users personal settings 

	//global variables
	var BOLD = " <b>";
	var UNBOLD = "</b>";
	var NOBOLD = " <nob>";
	var UNNOBOLD = "</nob>";


	// formats the tafs by sections within each taf by FM.. PROB.. TEMPO...
	function format_wx(string_in){

			var index;
			var re =/((TEMPO)|(FM[0-9]{6})|(PROB[0-9]{2})|(BECMG))\b/g;
			var found = string_in.match(re);
			if(found){	
				for(index = 0; index < found.length; ++index){
			      string_in = string_in.replace(/(?:\s)((TEMPO)|(FM[0-9]{6})|(PROB[0-9]{2})|(BECMG))\b/,  " <br><tab>" + found[index] + "</tab>");
			  		}
		       }
	       return string_in; 
	   }


	//send in metar or taf or both and the bolding will happen then be returned
	function boldline(string_in, limit, rep){
		// highlights if cloud layer is <= cigLimit
		if(limit['anyCloud']){
				var index;
				var re =/(FEW([0-9]{3})(CB)?(TCU)?(ACC)?\b(?!<))/;
				while(found = string_in.match(re)){
						if(found[2] <= Number(limit['anyCloud'])){ 
				      		string_in = string_in.replace(/(?:\s)(FEW([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, BOLD + found[1] + UNBOLD );
				  			}
				  		else{
				  			string_in = string_in.replace(/(?:\s)(FEW([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
				  		}	
			       }
			   }

		// highlights if SCT cloud layer is <= cigLimit
		if(limit['anyCloud']){
				var index;
				var re =/(SCT([0-9]{3})(CB)?(TCU)?(ACC)?\b(?!<))/;
				while(found = string_in.match(re)){
						if(found[2] <= Number(limit['anyCloud'])){ 
				      		string_in = string_in.replace(/(?:\s)(SCT([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, BOLD + found[1] + UNBOLD );
				  			}
				  		else{
				  			string_in = string_in.replace(/(?:\s)(SCT([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
				  		}	
			       }
			   }

		// highlights if BKN cloud layer is <= cigLimit
		if(limit['ceilings']){
				var index;
				var re =/(BKN([0-9]{3})(CB)?(TCU)?(ACC)?\b(?!<))/;
				while(found = string_in.match(re)){
						if(found[2] <= Number(limit['ceilings']) || found[2] <= Number(limit['anyCloud'])){
				      		string_in = string_in.replace(/(BKN([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, BOLD + found[1] + UNBOLD );
				  			}
				  		else{
				  			string_in = string_in.replace(/(BKN([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
				  		}	
			       }
			}

		// highlights if cloud layer is <= cigLimit
		if(limit['ceilings']){
				var index;
				var re =/(OVC([0-9]{3})(CB)?(TCU)?(ACC)?\b(?!<))/;
				while(found = string_in.match(re)){
						if(found[2] <= Number(limit['ceilings']) || found[2] <= Number(limit['anyCloud'])){ 
				      		string_in = string_in.replace(/(OVC([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, BOLD + found[1] + UNBOLD );
				  			}
				  		else{
				  			string_in = string_in.replace(/(OVC([0-9]{3})(CB)?(TCU)?(ACC)?\b)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
				  		}	
			       }
			   }

		//highlights a vertical visibility report if cloud layer is <= cigLimit
		if(limit['ceilings']){
			var index;
			var re =/(VV([0-9]{3})\b(?!<))/;
			while(found = string_in.match(re)){
					if(found[2] <= Number(limit['ceilings'])){ 
			      		string_in = string_in.replace(/(VV([0-9]{3})\b)(?!<)/, BOLD + found[1] + UNBOLD );
			  			}
			  		else{
			  			string_in = string_in.replace(/(VV([0-9]{3})\b)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
			  		}	
		       }
		   }

		//highlights a variable ceiling <= ceiling limit
		if(limit['ceilings']){
			var index;
			var re =/(CIG\s([0-9]{3})V([0-9]{3})\b(?!<))/;
			while(found = string_in.match(re)){
					if(found[2] <= Number(limit['ceilings'])){ 
			      		string_in = string_in.replace(/(CIG\s([0-9]{3})V([0-9]{3})\b(?!<))/, BOLD + found[1] + UNBOLD );
			  			}
			  		else{
			  			string_in = string_in.replace(/(CIG\s([0-9]{3})V([0-9]{3})\b(?!<))/, NOBOLD + found[1] + UNNOBOLD );
			  		}	
			    }
			 }

		//highlights winds if >= windLimid ***TODO: adjust for detecting gusts and wind/gust spread and windshifts
		if(limit['wind_limit']){
				var index;
				var re =/\s(([0-9]{3}|VRB)([0-9]{2,3})(G([0-9]{2,3}))?KT)(?!<)/;
				while(found = string_in.match(re)){
					if(found[3] >= Number(limit['wind_limit'])){ 
			      		string_in = string_in.replace(/\s(([0-9]{3}|VRB)([0-9]{2,3})(G([0-9]{2,3}))?KT)(?!<)/, BOLD + found[1] + UNBOLD );
			  			}
			  		else{
			  			string_in = string_in.replace(/\s(([0-9]{3}|VRB)([0-9]{2,3})(G([0-9]{2,3}))?KT)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
			  		}	
			    }
			 }

		if(rep['pk_wnd']){
				var index;
				var re =/(PK\sWND\s([0-9]{3})([0-9]{2,3})\/([0-9]{4}))\b/g;
				var found = string_in.match(re);
				if(found){	
					for(index = 0; index < found.length; ++index){
				      string_in = string_in.replace(/(?:\s)(PK\sWND\s([0-9]{3})([0-9]{2,3})\/([0-9]{4}))/, BOLD + found[index] + UNBOLD);
					    }
			       }
			   }

		//highlights any visibility report <= visLimit
		if(limit['visibility']){
			var temp;
				//check for just full whole SM number 
				var re =/\s(P?([0-9]{1,2})SM)(?!<)/;
				var found = string_in.match(re);
				while(found = string_in.match(re)){
					if(found[2] <= Number(limit['visibility'])){ 
			      		string_in = string_in.replace(/\s(P?([0-9]{1,2})SM)(?!<)/, BOLD + found[1] + UNBOLD );
			  			}
			  		else{
			  			string_in = string_in.replace(/\s(P?([0-9]{1,2})SM)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
			  		}	
			    }

			    //check for a visibility with a whole and fraction.. (2 1/2SM)
			    re =/(((\b)[0-9]\s)?M?([0-9])\/([0-9]{0,2})SM)(?!<)/;
				found = string_in.match(re);
				while(found = string_in.match(re)){

					//if there is a whole value with fraction
					if(found[2] != null && found[2] <= Number(limit['visibility'])){ 
						temp = found[4]/found[5];
						temp = temp + parseInt(found[2], 10);

						//after adding the fraction to the whole number
						if(temp <= Number(limit['visibility'])){
							string_in = string_in.replace(/(((\b)[0-9]\s)?([0-9])\/([0-9]{0,2})SM)(?!<)/, BOLD + found[1] + UNBOLD );
						}

			      		else{
			  			string_in = string_in.replace(/(((\b)[0-9]\s)?([0-9])\/([0-9]{0,2})SM)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
			  			}
			  		}


			  		//if it is just a fraction ... (1/2SM)
			  		else if(found[2] == null){
			  			temp = found[4]/found[5];

						//after adding the fraction to the whole number
						if(temp <= Number(limit['visibility'])){
								string_in = string_in.replace(/(((\b)[0-9]\s)?M?([0-9])\/([0-9]{0,2})SM)(?!<)/, BOLD + found[1] + UNBOLD );
							}

			      		else{
				  			string_in = string_in.replace(/(((\b)[0-9]\s)?M?([0-9])\/([0-9]{0,2})SM)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
				  			} 
			  			}

			  		else{
			  			string_in = string_in.replace(/(((\b)[0-9]\s)?([0-9])\/([0-9]{0,2})SM)(?!<)/, NOBOLD + found[1] + UNNOBOLD );
			  		}	
			    }
			}

		//bolds a RVR report
		if(1){
				var index;
				var re =/(R[0-9]{2}\w?\/(M|P)?([0-9]{4})V?P?([0-9]{4})?FT)\b/g;
				var found = string_in.match(re);
				if(found){	
					for(index = 0; index < found.length; ++index){
				      string_in = string_in.replace(/(?:\s)(R[0-9]{2}\w?\/(M|P)?([0-9]{4})V?P?([0-9]{4})?FT)/, BOLD + found[index] + UNBOLD);
					    }
			       }
			   }


		//bolds if temp/dewpoint spread <= spreadLimit or if temp is above or below users set limits
		if(1){
				var re =/\s((([M])?([0-9]{2}))\/(([M])?([0-9]{2}))(?=\s))/;
				//if set, then we dont need to re-bold the temperature
				var isbolded = false;
				var t,d;
				while(found = string_in.match(re)){

					// in the case the temp is negative (fixes temp)
					if(found[3] != null){
						t = 0 - parseInt(found[4], 10);
					}
					else{t = found[4];}
					
					// fixes dewpoint if negative
					if(found[6] != null){
						d = 0 - parseInt(found[7], 10);
					}
					else{d = found[7];}

					
					//if the diffeerence between temp/dew <= limit, highlight
					if((t-d) <= Number(limit['temp_dew_spread'])){ 
			      		string_in = string_in.replace(/\s((([M])?([0-9]{2}))\/(([M])?([0-9]{2}))(?=\s))/, " <b>" + found[1] + UNBOLD);
			      		isbolded = true;
			  			}
			  		//if we didnt bold already and we need to bold the temp
			  		else if(!isbolded & t <= Number(limit['l_temp']) || t >= Number(limit['h_temp'])){
			  			string_in = string_in.replace(/\s(([M])?([0-9]{2}))(?=\/)/, BOLD + found[2] + UNBOLD );
			  			//then nobold the dewpoint
			  		}
			  		else{
			  			string_in = string_in.replace(/\s((([M])?([0-9]{2}))\/(([M])?([0-9]{2}))(?=\s))/, " <nob>" + found[1] + UNNOBOLD);
			  		}	
			      }
			  }



		//bolds a temp <= lowtemp or temp >= hightemp (always checked)
		// if(0){
		// 		var re =/(([M])?([0-9]{2}))(?=\/)/;
		// 		while(found = string_in.match(re)){
		// 			// in the case the temp is negative
		// 			if(found[2] != null){
		// 				found[3] = 0 - parseInt(found[3], 10);
		// 			}
		// 				if(found[3] <= Number(limit['l_temp'])){ 
		// 		      		string_in = string_in.replace(/(([M])?([0-9]{2}))(?=\/)/, BOLD + found[1] + UNBOLD );
		// 		  			}
		// 		  		else if(found[3] >= Number(limit['h_temp'])){ 
		// 		      		string_in = string_in.replace(/(([M])?([0-9]{2}))(?=\/)/, BOLD + found[1] + UNBOLD );
		// 		  			}

		// 		  		else{
		// 		  			string_in = string_in.replace(/\s(([M])?([0-9]{2}))(?=\/)/, NOBOLD + found[1] + UNNOBOLD );
		// 		  		}	
		// 	       }
			       
		// 	   }





/*		if(W_set.check_alt){
				var index;
				var re =/(A([0-9]{4}))/g;
				var found = string_in.match(re);
				if(found){	
					for(index = 0; index < found.length; ++index){
				      string_in = string_in.replace(/(?:\s)(A([0-9]{4}))/, BOLD + found[index] + UNBOLD); //bold in place due to spacing with temp
					    }
			       }
			   }*/



		if(rep['slpno']){
			string_in = string_in.replace(/(SLPNO)/g, BOLD + "SLPNO" + UNBOLD);
		}
		if(rep['rvrno']){
			string_in = string_in.replace(/(RVRNO)/g, BOLD + "RVRNO" + UNBOLD);
		}
		if(rep['snincr']){
			string_in = string_in.replace(/(SNINCR)/g, BOLD + "SNINCR" + UNBOLD);
		}
		if(rep['presrr']){
			string_in = string_in.replace(/(ACFTMSHP)/g, BOLD + "ACFTMSHP" + UNBOLD);
		}
		if(rep['acftmshp']){
			string_in = string_in.replace(/(PRESFR)/g, BOLD + "PRESFR" + UNBOLD);
		}
		
		if(rep['ltg']){
				var index;
				var re =/((CONS\s)?(FRQ\s)?(OCNL\s)?(LTG)(\w+)?)/g;
				var found = string_in.match(re);
				if(found){	
					for(index = 0; index < found.length; ++index){
				      string_in = string_in.replace(/(?:\s)((CONS\s)?(FRQ\s)?(OCNL\s)?(LTG)(\w+)?)/, BOLD + found[index] + UNBOLD); //bold in place due to spacing with temp
					    }
			       }
			   }


		if(rep['fzrano']){
			string_in = string_in.replace(/(FZRANO)/g, BOLD + "FZRANO" + UNBOLD);
		}
		if(rep['fropa']){
			string_in = string_in.replace(/(FROPA)/g, BOLD + "FROPA" + UNBOLD);
		}
		if(rep['visno']){
			string_in = string_in.replace(/(VISNO)/g, BOLD + "VISNO" + UNBOLD);
		}

		//add windshift report highlight

		if(rep['tsno']){
			string_in = string_in.replace(/(TSNO)/g, BOLD + "TSNO" + UNBOLD);
		}


		//Highlights any metar thats time is older that the users metar age setting
		if(limit['metar_vtime']){

				//get current epcoh time
				var now = new Date();
				var epoch_now = now.valueOf()/1000;

				var expday = now.getUTCDate();
				var hour = now.getUTCHours();
				var minute = now.getUTCMinutes();
								
				var re =/(([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z))(?!<)(?!\s[0-9]{4}\/)/;
				while(found = string_in.match(re)){	
						
						//get day,hor,min report made
						met_dy = Number(found[4]);
						met_hr = Number(found[5]);
						met_mn = Number(found[6]);

						//get metar epoch time
						var met_epoch = Date.UTC(now.getFullYear(),now.getMonth(), met_dy, met_hr, met_mn).valueOf()/1000
						
						//console.log("now= " + epoch_now + " Metar epoch = " + met_epoch);
						var valid_until = (parseFloat(limit['metar_vtime']) * 3600) + met_epoch;
						
						//highlight if older than user setting for how old a metar should be
						if(epoch_now > valid_until){
							string_in = string_in.replace(/(([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z))(?!<)(?!\s[0-9]{4}\/)/, BOLD + found[1] + UNBOLD +" ");		
						}

				     	else{
				      		string_in = string_in.replace(/(([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z))(?!<)(?!\s[0-9]{4}\/)/, NOBOLD + found[1] + UNNOBOLD +" ");
				  		}
				  	}		       
			   }


		//Highlights any taf thats valid time is older that the users taf age setting
		if(limit['taf_vtime']){

				//get current epcoh time
				var now = new Date();
				var epoch_now = now.valueOf()/1000;

				var expday = now.getUTCDate();
				var hour = now.getUTCHours();
				var minute = now.getUTCMinutes();
								
				var re =/((TAF\s)?(AMD\s)?([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z)\s([0-9]{2})([0-9]{2})\/([0-9]{2})([0-9]{2}))(?!<)/;
				while(found = string_in.match(re)){	
						
						//get day,hor,min report made
						taf_dy = Number(found[9]);
						taf_hr = Number(found[10]);
						//taf_mn = Number(found[6]);

						//get metar epoch time
						var taf_epoch = Date.UTC(now.getFullYear(),now.getMonth(), taf_dy, taf_hr).valueOf()/1000
						
						
						var valid_until = (parseFloat(limit['taf_vtime']) * 3600) + taf_epoch;
						console.log("now= " + epoch_now + " TAF epoch = " + taf_epoch + "valid until = " + valid_until);
						//highlight if older than user setting for how old a metar should be
						if(epoch_now > valid_until){
							string_in = string_in.replace(/((TAF\s)?(AMD\s)?([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z)\s([0-9]{2})([0-9]{2})\/([0-9]{2})([0-9]{2}))(?!<)/, BOLD + found[1] + UNBOLD +" ");		
						}

				     	else{
				      		string_in = string_in.replace(/((TAF\s)?(AMD\s)?([A-Z0-9]{4})\s(([0-9]{2})([0-9]{2})([0-9]{2})Z)\s([0-9]{2})([0-9]{2})\/([0-9]{2})([0-9]{2}))(?!<)/, NOBOLD + found[1] + UNNOBOLD +" ");
				  		}
				  	}		       
			   }



		//break this down
		if(1){
				var index;
				var re = /(\s([\+\-]?)(VC)?(MI|RA|SN|BC|PR|TS|BL|SH|DR|FZ)?((DZ)|(RA)|(RAPL)|(SN)|(DZSN)|(RASNPL)|(RASN)|(SQ)|(IC)|(PE)|(BR)|(FG)|(FU)|(HZ)|(VA)|(DU)|(SA)|(DS)|(FC)|(MI)|(BC)|(DR)|(BL)|(TS)|(FZ)|(VC)|(SS)|(SG)|(SH)|(GR)|(GS)))(?=\s)/g;
				var found = string_in.match(re);
				if(found){	
					for(index = 0; index < found.length; ++index){
				      string_in = string_in.replace(/(\s([\+\-]?)(VC)?(MI|SN|RA|BC|PR|TS|BL|SH|DR|FZ)?((DZ)|(RA)|(RAPL)|(SN)|(DZSN)|(RASN)|(RASNPL)|(SQ)|(IC)|(PE)|(BR)|(FG)|(FU)|(HZ)|(VA)|(DU)|(SA)|(DS)|(FC)|(MI)|(BC)|(DR)|(BL)|(TS)|(FZ)|(VC)|(SS)|(SG)|(SH)|(GR)|(GS)))(?:\s)/, BOLD + found[index] + UNBOLD + " ");
				  		}
			       }
			   }

	// "BOLDED" string to return
	return string_in;  
	}



