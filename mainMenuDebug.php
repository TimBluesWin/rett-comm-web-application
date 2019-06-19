<meta charset="utf-8"/>
<html lang="id">
	<head title="Mau melakukan apa?">
		<style type="text/css">
		
		.heatmap-wrapper {
			position: absolute;
			left: 0;
			top: 0;
			-webkit-transition: .3s ease all;
			-moz-transition: .3s ease all;
			transition: .3s ease all;
		}

		.heatmap {
			width: 100%;
			height: 100%;

		}
		
		.iWantTo {
			position:absolute;
			top: 5%;
			left:50%;
			transform: translate(-50%, -50%);
			background-color: white;
			font-size: 36px;
		}
		
		.optionTextLeft {
			position: absolute;
			bottom: 5%;
			left: 25%;
			transform: translate(-50%, -50%);
			background-color: white;
			font-size: 36px
		}
		
		.optionTextRight {
			position: absolute;
			bottom: 5%;
			left: 75%;
			transform: translate(-50%, -50%);
			background-color: white;
			font-size: 36px
		}
		.option {
			float:left;
			width:50%;
			height:100%;
		}

		.pictures::after {
		  content:"";
		  clear: both;
		  display: table;
		}
		
		 html,body{
			height:100%;
		}
		</style>

	</head>
	<body>
		<div class="heatmap-wrapper" style="width: 100%; height: 100%;">
			<div class="heatmap" style="position: absolute;">

				<canvas width="100%" height="100%" class="heatmap-canvas" style="opacity: 0; left: 0; top: 0; position: absolute;">
				</canvas>
				<div class="pictures" style="width:100%; height:100%; z-index:1;">
					<div class="iWantTo" id="iWantTo" style="z-index:2; position:absolute"></div>
					<div class="option">
						<img src="makan.jpg" style="width:100%; height:100%; transform:rotate(90deg)" alt="makan">
						<div class="optionTextLeft" id="optionTextLeft">Makan</div>
					</div>
					<div class="option">
						<img src="minum.jpg" style="width:100%; height:100%; transform:rotate(90deg)" alt="minum">
						<div class="optionTextRight" id="optionTextRight">Minum</div>
					</div>
				</div>
			</div>
		</div>
		<script src="heatmap.js"></script>
		<script src="math.min.js"></script>
		<script>
		
		window.requestAnimationFrame = (function(){
          return  window.requestAnimationFrame       ||
                  window.webkitRequestAnimationFrame ||
                  window.mozRequestAnimationFrame    ||
                  function( callback ){
                    window.setTimeout(callback, 1000 / 60);
                  };
        })();
		//var thisCanvas = document.getElementById("heatmap-canvas");
		//var canvasWidth = thisCanvas.offsetWidth;
		//var canvasHeight = thisCanvas.offsetHeight;
		let timesLeft = 0;
		let timesRight = 0;
		let notDetected = 0;
		let text = ""
		// create instance
        let body = document.body;
		let width = body.clientWidth;
        let bodyStyle = getComputedStyle(body);
        let hmEl = document.querySelector('.heatmap-wrapper');

        hmEl.style.width = bodyStyle.width;
        hmEl.style.height = bodyStyle.height;

        let hm = document.querySelector('.heatmap');

        let heatmap = h337.create({
		
          container: hm,
          radius: 60,
        });


        let trackData = false;

        setInterval(function() {
          trackData = true;
        }, 50);

        let idleTimeout, idleInterval;
		let xCoordinates = [];
        let lastX, lastY;
        let idleCount;

        function startIdle() {
          idleCount = 0;
          function idle() {
            heatmap.addData({
              x: lastX,
              y: lastY
            });
            idleCount++;
            if (idleCount > 10) {
              clearInterval(idleInterval);
            }
          }
          idle();
          idleInterval = setInterval(idle, 1000);
        }



        body.onmousemove = function(ev) {
          if (idleTimeout) clearTimeout(idleTimeout);
          if (idleInterval) clearInterval(idleInterval);

          if (trackData) {
            lastX = ev.pageX;
            lastY = ev.pageY;
            heatmap.addData({
              x: lastX,
              y: lastY
            });
            trackData = false;
          }
		  if(lastX != null)
		  {
			xCoordinates.push(lastX);
		  }
		  if(lastX < width * 0.45)
		  {
			timesLeft = timesLeft + 1;
			
		  }
		  else if(lastX >= width * 0.55)
		  {
			timesRight = timesRight + 1;
			
		  }
		  else
		  {
		    notDetected = notDetected + 1;
		  }

		  //console.log("LastY " + lastY + "\n");
          idleTimeout = setTimeout(startIdle, 500);
        };
		
		setTimeout(function() 
		{
			
			if(timesLeft < 10 && timesRight < 10 && notDetected < 10)
			{
			    document.getElementById("iWantTo").innerHTML =  text + " Belum Tahu mau Ngapain";
			}
			else if(timesLeft >= timesRight * 7/3 && timesLeft >= notDetected * 7/3)
			{
				text += "Mean is " + math.mean(xCoordinates).toFixed(2) + "\n Std is " + math.std(xCoordinates).toFixed(2)
				document.getElementById("iWantTo").innerHTML = text + " Saya mau makan";
				
			}
			else if(timesRight >= timesLeft * 7/3 && timesRight >= notDetected * 7/3)
			{
				text += "Mean is " + math.mean(xCoordinates).toFixed(2) + "\n Std is " + math.std(xCoordinates).toFixed(2)
				document.getElementById("iWantTo").innerHTML = text + " Saya mau minum";
			}
			else
			{
				text += "Mean is " + math.mean(xCoordinates).toFixed(2) + "\n Std is " + math.std(xCoordinates).toFixed(2)
				document.getElementById("iWantTo").innerHTML = text + " Belum tahu mau ngapain";
			}
			
			//console.log(lastX);
			timesLeft = 0;
			timesRight = 0;
			heatmap.setData({data:[]});
			xCoordinates = [];
			text = "";
		},10*1000)
		</script>
		<?php
			
		?>
	</body>
</html>