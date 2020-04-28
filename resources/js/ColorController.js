export class ColorController {
    
    // Return a random color in HSL
    randomHSL = function (){
        return "hsla(" + ~~(360 * Math.random()) + "," +
                        "70%,"+
                        "80%,1)"
    }
    
    // Returns an array of HSL colors
    randomSeveral = function (num){
        let x = [];
        for( let i = num; i--; ){
          x[i] = this.randomHSL();
        }
        return x;
    }
}

//export default color;