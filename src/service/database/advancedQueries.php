<?php

function getAllActivityParticipants() {
    return customQuery("SELECT firstname, lastname, email, activity.tag FROM 
	activityParticipant 
    INNER JOIN activity ON activityParticipant.activityId=activity.id 
    INNER JOIN member ON member.id=activityParticipant.memberId ORDER BY activity.tag;");
}

function getAllInterests() {
    return customQuery("SELECT firstname, lastname, email, tag FROM member 
	INNER JOIN memberInterest ON member.id=memberInterest.memberId 
	INNER JOIN interest ON memberInterest.interestId=interest.id;");
}

function getAllContingencyState() {
    return customQuery("SELECT firstname, lastname, email, x.status FROM contingencyStatus x
	INNER JOIN (
    select memberId, max(date) AS maxDate, status
        from contingencyStatus
        group by memberId
    ) y on x.memberId=y.memberId AND x.date=maxDate
    INNER JOIN member ON x.memberId=member.id;");
}

function getAllPastMembers() {
    return customQuery("SELECT firstname, lastname, email FROM pastMember 
    INNER JOIN member on pastMember.memberId=member.id;");
}

function getMemberData($email) {
    return customQuery("SELECT a.id, firstname, lastname, phonenumber, email, password, gender, a.adressId, street, postalCode, city, 
       GROUP_CONCAT(d.tag) as interests 
FROM member a INNER JOIN adress b ON a.adressId=b.id INNER JOIN memberInterest c ON a.id=c.memberId INNER JOIN
interest d ON c.interestId=d.id WHERE a.email='" . $email . "'");
}

function hasInterestMembers($id) {
    $res = customQuery("select id, tag from interest a LEFT OUTER JOIN memberInterest b 
    ON a.id=b.interestId WHERE b.memberId IS NULL AND a.id=" . $id . ";");

    return !empty($res->fetch_all());
}

function getInterests($memberId) {
    return customQuery("SELECT GROUP_CONCAT(tag) 
FROM interest a INNER JOIN memberInterest b ON a.id=b.interestId WHERE memberId=" . $memberId . ";");
}
