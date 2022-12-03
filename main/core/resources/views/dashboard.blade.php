@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('/assets/css/core/guage.css')}}"/>
<style>
  .green {
    margin-top: 15px;
  }
  .green .progress,
  .red .progress,
  .orange .progress {
    position: relative;
    border-radius: 50%;
  }
  .green .progress,
  .red .progress,
  .orange .progress {
    width: 150px;
    height: 150px;
  }
  .green .progress {
    border: 5px solid #53fc53;
  }
  .green .progress {
    box-shadow: 0 0 20px #029502;
  }
  .green .progress,
  .red .progress,
  .orange .progress {
    transition: all 1s ease;
  }
  .green .progress .inner,
  .red .progress .inner,
  .orange .progress .inner {
    position: absolute;
    overflow: hidden;
    z-index: 2;
    border-radius: 50%;
  }
  .green .progress .inner,
  .red .progress .inner,
  .orange .progress .inner {
    width: 140px;
    height: 140px;
  }
  .green .progress .inner,
  .red .progress .inner,
  .orange .progress .inner {
    border: 5px solid #1a1a1a;
  }
  .green .progress .inner,
  .red .progress .inner,
  .orange .progress .inner {
    transition: all 1s ease;
  }
  .green .progress .inner .water,
  .red .progress .inner .water,
  .orange .progress .inner .water {
    position: absolute;
    z-index: 1;
    width: 200%;
    height: 200%;
    left: -50%;
    border-radius: 40%;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    -webkit-animation-timing-function: linear;
    animation-timing-function: linear;
    -webkit-animation-name: spin;
    animation-name: spin;
  }
  .green .progress .inner .water {
    top: 25%;
  }
  .green .progress .inner .water {
    background: rgba(83,252,83,0.5);
  }
  .green .progress .inner .water,
  .red .progress .inner .water,
  .orange .progress .inner .water {
    transition: all 1s ease;
  }
  .green .progress .inner .water,
  .red .progress .inner .water,
  .orange .progress .inner .water {
    -webkit-animation-duration: 10s;
    animation-duration: 10s;
  }
  .green .progress .inner .water {
    box-shadow: 0 0 20px #03bc03;
  }
  .green .progress .inner .glare,
  .red .progress .inner .glare,
  .orange .progress .inner .glare {
    position: absolute;
    top: -120%;
    left: -120%;
    z-index: 5;
    width: 200%;
    height: 200%;
    transform: rotate(45deg);
    border-radius: 50%;
  }
  .green .progress .inner .glare,
  .red .progress .inner .glare,
  .orange .progress .inner .glare {
    background-color: rgba(255,255,255,0.15);
  }
  .green .progress .inner .glare,
  .red .progress .inner .glare,
  .orange .progress .inner .glare {
    transition: all 1s ease;
  }
  .green .progress .inner .percent,
  .red .progress .inner .percent,
  .orange .progress .inner .percent {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    font-weight: bold;
    text-align: center;
  }
  .green .progress .inner .percent,
  .red .progress .inner .percent,
  .orange .progress .inner .percent {
    line-height: 140px;
    font-size: 30.3076923076923px;
  }
  .green .progress .inner .percent {
    color: #03c603;
  }
  .green .progress .inner .percent {
    text-shadow: 0 0 10px #029502;
  }
  .green .progress .inner .percent,
  .red .progress .inner .percent,
  .orange .progress .inner .percent {
    transition: all 1s ease;
  }
  .red {
    margin-top: 15px;
  }
  .red .progress {
    border: 5px solid #ed3b3b;
  }
  .red .progress {
    box-shadow: 0 0 20px #7a0b0b;
  }
  .red .progress .inner .water {
    top: 75%;
  }
  .red .progress .inner .water {
    background: rgba(237,59,59,0.5);
  }
  .red .progress .inner .water {
    box-shadow: 0 0 20px #9b0e0e;
  }
  .red .progress .inner .percent {
    color: #a30f0f;
  }
  .red .progress .inner .percent {
    text-shadow: 0 0 10px #7a0b0b;
  }
  .orange {
    margin-top: 15px;
  }
  .orange .progress {
    border: 5px solid #f07c3e;
  }
  .orange .progress {
    box-shadow: 0 0 20px #7e320a;
  }
  .orange .progress .inner .water {
    top: 50%;
  }
  .orange .progress .inner .water {
    background: rgba(240,124,62,0.5);
  }
  .orange .progress .inner .water {
    box-shadow: 0 0 20px #a0400c;
  }
  .orange .progress .inner .percent {
    color: #a8430d;
  }
  .orange .progress .inner .percent {
    text-shadow: 0 0 10px #7e320a;
  }
  @-webkit-keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
  @keyframes spin {
    from {
      transform: rotate(0deg);
    }
    to {
      transform: rotate(360deg);
    }
  }
</style>
@endsection
@section('header')
<div>
    <h1>Hello!</h1>
    <p>We are on a mission to develop an application which is powerd by dockers</p>
</div>
<div>
    <a href="" class="btn btn-link btn-soft-light">
        <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.8251 15.2171H12.1748C14.0987 15.2171 15.731 13.985 16.3054 12.2764C16.3887 12.0276 16.1979 11.7713 15.9334 11.7713H14.8562C14.5133 11.7713 14.2362 11.4977 14.2362 11.16C14.2362 10.8213 14.5133 10.5467 14.8562 10.5467H15.9005C16.2463 10.5467 16.5263 10.2703 16.5263 9.92875C16.5263 9.58722 16.2463 9.31075 15.9005 9.31075H14.8562C14.5133 9.31075 14.2362 9.03619 14.2362 8.69849C14.2362 8.35984 14.5133 8.08528 14.8562 8.08528H15.9005C16.2463 8.08528 16.5263 7.8088 16.5263 7.46728C16.5263 7.12575 16.2463 6.84928 15.9005 6.84928H14.8562C14.5133 6.84928 14.2362 6.57472 14.2362 6.23606C14.2362 5.89837 14.5133 5.62381 14.8562 5.62381H15.9886C16.2483 5.62381 16.4343 5.3789 16.3645 5.13113C15.8501 3.32401 14.1694 2 12.1748 2H11.8251C9.42172 2 7.47363 3.92287 7.47363 6.29729V10.9198C7.47363 13.2933 9.42172 15.2171 11.8251 15.2171Z" fill="currentColor"></path>
            <path opacity="0.4" d="M19.5313 9.82568C18.9966 9.82568 18.5626 10.2533 18.5626 10.7823C18.5626 14.3554 15.6186 17.2627 12.0005 17.2627C8.38136 17.2627 5.43743 14.3554 5.43743 10.7823C5.43743 10.2533 5.00345 9.82568 4.46872 9.82568C3.93398 9.82568 3.5 10.2533 3.5 10.7823C3.5 15.0873 6.79945 18.6413 11.0318 19.1186V21.0434C11.0318 21.5715 11.4648 22.0001 12.0005 22.0001C12.5352 22.0001 12.9692 21.5715 12.9692 21.0434V19.1186C17.2006 18.6413 20.5 15.0873 20.5 10.7823C20.5 10.2533 20.066 9.82568 19.5313 9.82568Z" fill="currentColor"></path>
        </svg>
        Announcements
    </a>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4" id="cpu">
      <div class="m-5 d-flex flex-column align-items-center">
        <div class="green">
        <div class="progress dark">
          <div class="inner dark">
            <div class="percent"><span>0</span>%</div>
            <div class="water"></div>
            <div class="glare"></div>
          </div>
        </div>
        </div>
        <h2 class="mt-2">CPU</h2>
      </div>
    </div>
    <div class="col-lg-4" id="ram">
      <div class="m-5 d-flex flex-column align-items-center">
      <div class="green">
        <div class="progress dark">
          <div class="inner dark">
            <div class="percent"><span>0</span>%</div>
            <div class="water"></div>
            <div class="glare"></div>
          </div>
        </div>
      </div>
      <h2 class="mt-2">RAM</h2>
      </div>
    </div>
    <div class="col-lg-4" id="disk">
      <div class="m-5 d-flex flex-column align-items-center">
      <div class="green">
        <div class="progress dark">
          <div class="inner dark">
            <div class="percent"><span>0</span>%</div>
            <div class="water"></div>
            <div class="glare"></div>
          </div>
        </div>
      </div>
      <h2 class="mt-2">DISK</h2>
      </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/@stomp/stompjs@5.0.0/bundles/stomp.umd.min.js" type="text/javascript"></script>
<script>
const client = new StompJs.Client({
  brokerURL: 'ws://localhost:15674/ws',
  connectHeaders: {
    login: 'guest',
    passcode: 'guest',
  },
  debug: function (str) {
    // console.log(str);
  },
  reconnectDelay: 5000,
  heartbeatIncoming: 4000,
  heartbeatOutgoing: 4000,
});

client.onConnect = function (frame) {
  const callback = function (message) {
    // called when the client receives a STOMP message from the server
    if (message.body) {
      var data = JSON.parse(message.body);
      console.log(data);
      var cpu = (data.cpu!=undefined && data.cpu!=null && data.cpu!="") ? data.cpu : 0;
      var ram = (data.ram!=undefined && data.ram!=null && data.ram!="") ? data.ram : 0;
      var disk = (data.disk!=undefined && data.disk!=null && data.disk!="") ? data.disk : 0;
      var colorInc = 100 / 3;
      
      if(cpu != "" && !isNaN(cpu) && cpu <= 100 && cpu >= 0)
      {

        var valOrig = cpu;
        cpu = 100 - cpu;

        valOrig = valOrig < 1 ? 1 : valOrig;

        if(valOrig == 0)
        {
          $("#cpu .progress .percent").text(0 + "%");
        }
        else $("#cpu .progress .percent").text(Math.round(valOrig)+ "%");

        $("#cpu .progress").parent().removeClass();
        $("#cpu .progress .water").css("top", cpu + "%");

        if(valOrig < colorInc * 1)
          $("#cpu .progress").parent().addClass("green");
        else if(valOrig < colorInc * 2)
          $("#cpu .progress").parent().addClass("orange");
        else
          $("#cpu .progress").parent().addClass("red");
      }
      else
      {
        $("#cpu .progress").parent().removeClass();
        $("#cpu .progress").parent().addClass("green");
        $("#cpu .progress .water").css("top", 100 - 0 + "%");
        $("#cpu .progress .percent").text(0 + "%");
      }

      if(ram != "" && !isNaN(ram) && ram <= 100 && ram >= 0)
      {

        var valOrig = ram;
        ram = 100 - ram;
        valOrig = valOrig < 1 ? 1 : valOrig;

        if(valOrig == 0)
        {
          $("#ram .progress .percent").text(0 + "%");
        }
        else $("#ram .progress .percent").text(Math.round(valOrig)+ "%");

        $("#ram .progress").parent().removeClass();
        $("#ram .progress .water").css("top", ram + "%");

        if(valOrig < colorInc * 1)
          $("#ram .progress").parent().addClass("green");
        else if(valOrig < colorInc * 2)
          $("#ram .progress").parent().addClass("orange");
        else
          $("#ram .progress").parent().addClass("red");
      }
      else
      {
        $("#ram .progress").parent().removeClass();
        $("#ram .progress").parent().addClass("green");
        $("#ram .progress .water").css("top", 100 - 0 + "%");
        $("#ram .progress .percent").text(0 + "%");
      }

      if(disk != "" && !isNaN(disk) && disk <= 100 && disk >= 0)
      {

        var valOrig = disk;
        disk = 100 - disk;
        valOrig = valOrig < 1 ? 1 : valOrig;

        if(valOrig == 0)
        {
          $("#disk .progress .percent").text(0 + "%");
        }
        else $("#disk .progress .percent").text(Math.round(valOrig)+ "%");

        $("#disk .progress").parent().removeClass();
        $("#disk .progress .water").css("top", disk + "%");

        if(valOrig < colorInc * 1)
          $("#disk .progress").parent().addClass("green");
        else if(valOrig < colorInc * 2)
          $("#disk .progress").parent().addClass("orange");
        else
          $("#disk .progress").parent().addClass("red");
      }
      else
      {
        $("#disk .progress").parent().removeClass();
        $("#disk .progress").parent().addClass("green");
        $("#disk .progress .water").css("top", 100 - 0 + "%");
        $("#disk .progress .percent").text(0 + "%");
      }

    } else {
      $("#cpu .progress").parent().removeClass();
      $("#cpu .progress").parent().addClass("green");
      $("#cpu .progress .water").css("top", 100 - 0 + "%");
      $("#cpu .progress .percent").text(0 + "%");
      $("#ram .progress").parent().removeClass();
      $("#ram .progress").parent().addClass("green");
      $("#ram .progress .water").css("top", 100 - 0 + "%");
      $("#ram .progress .percent").text(0 + "%");
      $("#disk .progress").parent().removeClass();
      $("#disk .progress").parent().addClass("green");
      $("#disk .progress .water").css("top", 100 - 0 + "%");
      $("#disk .progress .percent").text(0 + "%");
    }
  };
  const subscription = client.subscribe('/topic/test', callback);

};

// client.onStompError = function (frame) {
//   // Will be invoked in case of error encountered at Broker
//   // Bad login/passcode typically will cause an error
//   // Complaint brokers will set `message` header with a brief message. Body may contain details.
//   // Compliant brokers will terminate the connection after any error
//   // console.log('Broker reported error: ' + frame.headers['message']);
//   // console.log('Additional details: ' + frame.body);
// };

client.activate();

$("#cpu .progress").parent().removeClass();
$("#cpu .progress").parent().addClass("green");
$("#cpu .progress .water").css("top", 100 - 0 + "%");
$("#cpu .progress .percent").text(0 + "%");
$("#ram .progress").parent().removeClass();
$("#ram .progress").parent().addClass("green");
$("#ram .progress .water").css("top", 100 - 0 + "%");
$("#ram .progress .percent").text(0 + "%");
$("#disk .progress").parent().removeClass();
$("#disk .progress").parent().addClass("green");
$("#disk .progress .water").css("top", 100 - 0 + "%");
$("#disk .progress .percent").text(0 + "%");


</script>
@endsection