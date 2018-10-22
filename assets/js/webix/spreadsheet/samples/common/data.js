var base_data = {
  "styles": [
	["top","#FFEFEF;#6E6EFF;center;'PT Sans', Tahoma;17px;"],						
	["subtop","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["sales","#818181;;center;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["total","#818181;;right;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["count","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;;top;;"],
	["calc-top","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["calc-other","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;middle;;"],
	["values","#000;#fff;right;'PT Sans', Tahoma;15px;;;;top;;;price"]
  ],
  "sizes": [
    [0,1,125],
    [0,3,137],
    [0,4,137],
	[0,5,137]
  ],
  "data": [
    [1,1,"Report - July 2016","top"],    
    [2,1,"Region","subtop"],
    [2,2,"Country","subtop"],
    [2,3,"Sales - Group A","sales"],
    [2,4,"Sales - Group B","sales"],
    [2,5,"Total","total"],
    [3,1,"Europe","count"],
    [3,2,"Germany","count"],
    [3,3,"188400","values"],
    [3,4,"52000","values"],
    [3,5,"=C3+D3","values"],
    [4,1,"Europe","count"],
    [4,2,"France","count"],
    [4,3,"192200","values"],
    [4,4,"12000","values"],
    [4,5,"=C4+D4","values"],
    [5,1,"Europe","count"],
    [5,2,"Poland","count"],
    [5,3,"68900","values"],
    [5,4,"8000","values"],
    [5,5,"=C5+D5","values"],
    [6,1,"Asia","count"],
    [6,2,"Japan","count"],
    [6,3,"140000","values"],
    [6,4,"14000","values"],
    [6,5,"=C6+D6","values"],
    [7,1,"Asia","count"],
    [7,2,"China","count"],
    [7,3,"50000","values"],
    [7,4,"4800","values"],
    [7,5,"=C7+D7","values"]
  ],
  "spans": [
    [1,1,5,1]
  ]
};

var math_data = {
  "styles": [    
	["top","#FFEFEF;#6E6EFF;center;'PT Sans', Tahoma;17px;"],						
	["subtop","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;bold;top;;;"],
	["count","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;;top;;;"],
	["calc-top","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;top;;;"],
	["calc-other","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;middle;;;"]
  ],  
  "data": [   
	[1, 1, "Report 2015", "top"],	
	[2, 1, "Countries:", "subtop"],
		[3, 1, "France", "count"],
		[4, 1, "Poland", "count"],
		[5, 1, "China", "count"],
	[2, 2, "April", "count"],
		[3, 2, 1366],
		[4, 2, 684],
		[5, 2, 8142],						
	[2, 3, "May", "count"],
		[3, 3, 842],
		[4, 3, 781],
		[5, 3, 7813],					
	[2, 4, "June", "count"],
		[3, 4, 903],
		[4, 4, 549],
		[5, 4, 7754],						
	[2, 5, "July", "count"],
		[3, 5, 806],
		[4, 5, 978],
		[5, 5, 8199],						
	[2, 6, "Total:", "calc-top"],
		[3, 6, "=SUM(B3:E3)"],
		[4, 6, "=SUM(B4:E4)"],
		[5, 6, "=SUM(B5:E5)"],	
	[2, 7, "Std Deviation:", "calc-top"],
		[3, 7, "=STDEVP(B3:E3)"],
		[4, 7, "=STDEVP(B4:E4)"],
		[5, 7, "=STDEVP(B5:E5)"],	
	[7, 2, "You can use native Excel math"],
	[8, 2, "Just type something like \"=A1+B2\" or \"=SUM(A1:A8)\""]
  ],
  "spans": [ 
	[1, 1, 7, 1],
	[1, 8, 1, 2],
	[7, 2, 5, 1],
	[8, 2, 5, 1]	
  ],
  "sizes":[
	[0, 7, 130],						
	[0, 8, 200]
  ]
};

var math_data_simple = {
  "styles": [    
	["top","#FFEFEF;#6E6EFF;center;'PT Sans', Tahoma;17px;"],						
	["subtop","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["count","#818181;#EAEAEA;center;'PT Sans', Tahoma;15px;;;;top;;"],
	["calc-top","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;top;;"],
	["calc-other","#818181;#EAEAEA;;'PT Sans', Tahoma;15px;;;bold;middle;;"]
  ],  
  "data": [   
	[1, 1, "Countries:", "subtop"],
		[2, 1, "France", "count"],
		[3, 1, "Poland", "count"],
		[4, 1, "China", "count"],
	[1, 2, "April", "count"],
		[2, 2, 1366],
		[3, 2, 684],
		[4, 2, 8142],						
	[1, 3, "May", "count"],
		[2, 3, 842],
		[3, 3, 781],
		[4, 3, 7813],					
	[1, 4, "June", "count"],
		[2, 4, 903],
		[3, 4, 549],
		[4, 4, 7754],						
	[1, 5, "July", "count"],
		[2, 5, 806],
		[3, 5, 978],
		[4, 5, 8199],						
	[1, 6, "Total:", "calc-top"],
		[2, 6, "=SUM(B2:E2)"],
		[3, 6, "=SUM(B3:E3)"],
		[4, 6, "=SUM(B4:E4)"],	
	[1, 7, "Std Deviation:", "calc-top"],
		[2, 7, "=STDEVP(B2:E2)"],
		[3, 7, "=STDEVP(B3:E3)"],
		[4, 7, "=STDEVP(B4:E4)"]
  ],
  "sizes":[
	[0, 7, 130],						
	[0, 8, 200]
  ]
};

var sheet1_data = {"data":[["1","1","","wss8"],["1","2","","wss6"],["1","3","Sales","wss7"],["1","4","","wss6"],["1","5","Prediction","wss4"],["2","1","Department","wss1"],["2","2","2013","wss3"],["2","3","2014","wss3"],["2","4","2015","wss3"],["2","5","2016","wss3"],["3","1","Sport gears",""],["3","2","4550","wss5"],["3","3","4780","wss5"],["3","4","4920","wss5"],["3","5","5904","wss5"],["4","1","Gadgets",""],["4","2","2245","wss5"],["4","3","4483","wss5"],["4","4","7460","wss5"],["4","5","8952","wss14"],["5","1","Beverage",""],["5","2","750","wss5"],["5","3","640","wss5"],["5","4","755","wss5"],["5","5","830.5","wss5"],["6","1","Total","wss11"],["6","2","=SUM(B3:B5)","wss12"],["6","3","=SUM(C3:C5)","wss12"],["6","4","=SUM(D3:D5)","wss12"],["6","5","=SUM(E3:E5)","wss12"]],"styles":[["wss1",";#CEFEFE;"],["wss2",";#CEE6FE;"],["wss3","#000000;#CEE6FE;center"],["wss4","#000000;#CEFEFE;center"],["wss5",";;center"],["wss6","#000000;#CEFEE6;left"],["wss7","#000000;#CEFEE6;center"],["wss8","#000000;#FFFFFF;left"],["wss9","#FFFFFF;;"],["wss10","#FFFFFF;#424242;"],["wss11","#FFFFFF;#424242;right"],["wss12","#FFFFFF;#424242;center"],["wss13","#000000;#ffffff;left"],["wss14","#000000;#ffffff;center"]],"sizes":[["0","1","169"]],"spans":[]};
var sheet2_data = {"data":[["2","2","-","wss1"],["2","3","Page 1","wss2"],["2","4","-",""],["3","2","","wss3"],["3","3","","wss3"],["3","4","","wss3"]],"styles":[["wss1",";;right"],["wss2",";;center"],["wss3",";#f6b26b;"]],"sizes":[],"spans":[]};
var sheet3_data = {"data":[["2","2","-","wss1"],["2","3","Page 2","wss5"],["2","4","-",""],["3","2","","wss6"],["3","3","","wss6"],["3","4","","wss6"]],"styles":[["wss1",";;right"],["wss2",";;center"],["wss3",";#9E3EFF;"],["wss4","#000000;#ffffff;right"],["wss5","#000000;#ffffff;center"],["wss6","#000000;#6d9eeb;left"]],"sizes":[],"spans":[]};

