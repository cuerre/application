export default class ColorGenerator{

    getColors (numOfColors) {
        let colors = new Array(numOfColors).fill(0)

        for (let i = 0; i < numOfColors; i++) {
        let color = parseInt((360 / numOfColors) * Math.random()) + ((360 / numOfColors) * (i + 1))

        for (let j = 0; j < numOfColors; j++) {
            if ((color > colors[j] - 60) || (color < colors[j] + 60)) {
            color = color + parseInt(colors[j] * Math.random() + colors[j])
            }

            if (color > 360) {
            color = color - 360
            }
        }
        colors[i] = 'hsla(' + color + ',70%,80%,1)'
        }

        return colors
    }

}
