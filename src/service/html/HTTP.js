/**
 * Sender en POST til URL'en
 * @param url URL'en til mottaker
 * @param data dataen som skal sendes
 * @param headers headere til requesten
 * @returns svar fra tjeneren i tekst
 */
const doPost = (url, data, headers, callback) => {
    $.ajax({
        type: "POST",
        url: url,
        headers: headers,
        data: data,
    }).done((e) => callback(e));
}