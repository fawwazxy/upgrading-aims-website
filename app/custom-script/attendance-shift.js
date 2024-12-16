function addHoursAndMinutesToTime(startTime, totalHour){
    let hours = Math.floor(totalHour);
    let minutes = (totalHour - hours) * 60;

    startTime.setMinutes(startTime.getMinutes() + minutes);
    startTime.setHours(startTime.getHours() + hours);

    let newMinutes = startTime.getMinutes();
    let newHours = startTime.getHours();

    newMinutes = newMinutes.toString().length<2 ? '0'+newMinutes : newMinutes;
    newHours = newHours.toString().length<2 ? '0'+newHours : newHours;

    return newHours + ":" + newMinutes + ":00";
}