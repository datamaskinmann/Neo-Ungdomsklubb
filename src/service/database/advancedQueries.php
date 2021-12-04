<?php

function getAllActivityParticipants()
{
    return customQuery("SELECT firstname, lastname, email, activity.tag FROM 
	activityParticipant 
    INNER JOIN activity ON activityParticipant.activityId=activity.id 
    INNER JOIN member ON member.id=activityParticipant.memberId ORDER BY activity.tag;");
}

function getAllInterests()
{
    return customQuery("SELECT firstname, lastname, email, tag FROM member 
	INNER JOIN memberInterest ON member.id=memberInterest.memberId 
	INNER JOIN interest ON memberInterest.interestId=interest.id;");
}

function getAllContingencyState()
{
    return customQuery("SELECT firstname, lastname, email, x.status FROM contingencyStatus x
	INNER JOIN (
    select memberId, max(date) AS maxDate, status
        from contingencyStatus
        group by memberId
    ) y on x.memberId=y.memberId AND x.date=maxDate
    INNER JOIN member ON x.memberId=member.id;");
}
