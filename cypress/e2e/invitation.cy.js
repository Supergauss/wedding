describe('Einladung', () => {
    it('Neue Gäste anlegen', () => {
        cy.login();
        cy.visit('/admin');

        // Einzelnen Familiengast einladen
        cy.contains('.btn.btn-primary', 'Neuen Gast anlegen').click();
        cy.get('#invitation_salutation').select('Ein Freund/Ein männliches Familienmitglied')
        cy.get('#invitation_name').type('Hans Meyer');
        cy.get('#invitation_is_family').check();
        cy.contains('.btn.btn-primary', 'Speichern').click();

        cy.contains('.alert-success', 'Hans Meyer wurde angelegt');
        cy.contains('td', 'Hans Meyer');
        cy.contains('td', 'Noch keine Rückmeldung');
        cy.contains('td', 'Ein Freund/Ein männliches Familienmitglied');
        cy.contains('td', '30.04.2025');

// Mehrere Familienmitglieder einladen
        cy.contains('.btn.btn-primary', 'Neuen Gast anlegen').click();
        cy.get('#invitation_salutation').select('Mehrere Freunde/Mehrere Familienmitglieder')
        cy.get('#invitation_name').type('Gudrun & Peter Gauß');
        cy.get('#invitation_is_family').check();
        cy.get('#invitation_number_guests_invited').clear().type('2');
        cy.contains('.btn.btn-primary', 'Speichern').click();


        cy.contains('.alert-success', 'Gudrun & Peter Gauß wurde angelegt');
        cy.contains('td', 'Gudrun & Peter Gauß');
        cy.contains('td', 'Mehrere Freunde/Mehrere Familienmitglieder');

// Ein weiblichen frund einladen
        cy.contains('.btn.btn-primary', 'Neuen Gast anlegen').click();
        cy.get('#invitation_salutation').select('Eine Freundin/Ein weibliches Familienmitglied')
        cy.get('#invitation_name').type('Petra Düring');
        cy.contains('.btn.btn-primary', 'Speichern').click();


        cy.contains('.alert-success', 'Petra Düring wurde angelegt');
        cy.contains('td', 'Petra Düring');
        cy.contains('td', 'Eine Freundin/Ein weibliches Familienmitglied');

// Mehrere Freunde einladen
        cy.contains('.btn.btn-primary', 'Neuen Gast anlegen').click();
        cy.get('#invitation_salutation').select('Mehrere Freunde/Mehrere Familienmitglieder');
        cy.get('#invitation_name').type('Loki, Johan, Hedda, Henri, Annika & Alexander Frech');
        cy.get('#invitation_number_guests_invited').clear().type('6');
        cy.contains('.btn.btn-primary', 'Speichern').click();


        cy.contains('.alert-success', 'Loki, Johan, Hedda, Henri, Annika & Alexander Frech wurde angelegt');
        cy.contains('td', 'Loki, Johan, Hedda, Henri, Annika & Alexander Frech');
    });

    it('Ansicht - Familie - Single', () => {
        cy.login();
        cy.visit('/admin');
        cy.contains('a', 'Link kopieren für Hans Meyer').invoke('attr', 'href')
            .then(href => {
                cy.visit(href);
            });
        cy.contains('Lieber Hans Meyer,');
        cy.contains('wir möchten dich gerne zu unserer Hochzeit einladen.');
        cy.contains('Restaurant');
    });

    it('Ansicht - Familie - Mehrere', () => {
        cy.login();
        cy.visit('/admin');
        cy.contains('a', 'Link kopieren für Gudrun & Peter Gauß').invoke('attr', 'href')
            .then(href => {
                cy.visit(href);
            });
        cy.contains('Liebe Gudrun & Peter Gauß,');
        cy.contains('wir möchten euch gerne zu unserer Hochzeit einladen.');
        cy.contains('Restaurant');
    });

    it.only('Ansicht - Freunde - Single', () => {
        cy.login();
        cy.visit('/admin');
        cy.contains('a', 'Link kopieren für Petra Düring').invoke('attr', 'href')
            .then(href => {
                cy.visit(href);
            });
        cy.contains('Liebe Petra Düring,');
        cy.contains('wir möchten dich gerne zu unserer Hochzeit einladen.');
        cy.get('h3').should('not.have.text', 'Restaurant')
    });

    it.only('Ansicht - Freunde - Mehrere', () => {
        cy.login();
        cy.visit('/admin');
        cy.contains('a', 'Link kopieren für Loki, Johan, Hedda, Henri, Annika & Alexander Frech').invoke('attr', 'href')
            .then(href => {
                cy.visit(href);
            });
        cy.contains('Liebe Loki, Johan, Hedda, Henri, Annika & Alexander Frech,');
        cy.contains('wir möchten euch gerne zu unserer Hochzeit einladen.');
        cy.get('h3').should('not.have.text', 'Restaurant')
    });
})