function buttonOne() 
{
    let id="1";
    showGraph(id);
}
function buttonTwo() 
{
    let id="2";
    showGraph(id);
}
function buttonThree() 
{
    let id="3";
    showGraph(id);
}
function buttonFour() 
{
    let id="4";
    showGraph(id);
}
function buttonFive() 
{
    let id="5";
    showGraph(id);
}
function buttonSix() 
{
    let id="6";
    showGraph(id);
}
function buttonSeven() 
{
    let id="7";
    showGraph(id);
}
function showGraph(id)
{
    switch (id)
    {
        case "1":
            if (nbIncident.style.display === "none") 
            {
                nbIncident.style.display = "block";
                incidentType.style.display = "none";
                bubble.style.display = "none";
                trancheHoraire.style.display = "none";
                localisation.style.display = "none";
                casClasse.style.display = "none";
                profs.style.display = "none";
            } 
            break;
        case "2":
            if (incidentType.style.display === "none") 
            {
                incidentType.style.display = "block";
                nbIncident.style.display = "none";
                bubble.style.display = "none";
                trancheHoraire.style.display = "none";
                localisation.style.display = "none";
                casClasse.style.display = "none";
                profs.style.display = "none";
            }
            break;
        case "3":
            if (bubble.style.display === "none") 
            {
                bubble.style.display = "block";
                nbIncident.style.display = "none";
                incidentType.style.display = "none";
                trancheHoraire.style.display = "none";
                localisation.style.display = "none";
                casClasse.style.display = "none";
                profs.style.display = "none";
            }
            break;
        case "4":
            if (trancheHoraire.style.display === "none") 
            {
                trancheHoraire.style.display = "block";
                nbIncident.style.display = "none";
                incidentType.style.display = "none";
                bubble.style.display = "none";
                localisation.style.display = "none";
                casClasse.style.display = "none";
                profs.style.display = "none";
            }
            break;
        case "5":
            if (localisation.style.display === "none") 
            {
                localisation.style.display = "block";
                nbIncident.style.display = "none";
                incidentType.style.display = "none";
                bubble.style.display = "none";
                trancheHoraire.style.display = "none";
                casClasse.style.display = "none";
                profs.style.display = "none";
            }
            break;
        case "6":
            if (casClasse.style.display === "none") 
            {
                casClasse.style.display = "block";
                nbIncident.style.display = "none";
                incidentType.style.display = "none";
                bubble.style.display = "none";
                trancheHoraire.style.display = "none";
                localisation.style.display = "none";
                profs.style.display = "none";
            }
            break;
        case "7":
            if (profs.style.display === "none") 
            {
                profs.style.display = "block";
                nbIncident.style.display = "none";
                incidentType.style.display = "none";
                bubble.style.display = "none";
                trancheHoraire.style.display = "none";
                localisation.style.display = "none";
                casClasse.style.display = "none";
            }
            break;
        default:
            if (incidentType.style.display === "none") 
            {
                incidentType.style.display = "block";
            }
            break;

    }
}