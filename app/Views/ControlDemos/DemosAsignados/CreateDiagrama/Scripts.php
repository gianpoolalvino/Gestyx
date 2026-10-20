<script>
    let canvas = new fabric.Canvas("bcPaint");
    canvas.setWidth(600);
    canvas.setHeight(600);
    let rect = new fabric.Rect({
       left:100,
       top:100,
       fill:'red',
       width:50,
       height:50
    });

    let imgNode = new Image();
    imgNode.src = '<?php echo base_url("resource/img/diagramaVehiculo.png")?>';
    imgNode.onload = ()=>{
        let img = new fabric.Image(imgNode,{
            left:50,
            top:50,
            angle:0,
            opacity:0
        })
        canvas.add(img);
    }
    canvas.add(rect);
</script>