describe('Einladung', () => {
  it('Neue Gäste anlegen', () => {
    cy.login();
    cy.visit('/admin');
    cy.contains('.btn.btn-primary', 'Neuen Gast anlegen').click();
    cy.get('#invitation_salutation').select('Ein Freund/Ein männliches Familienmitglied')
    cy.get('#invitation_name').type('Hans Meyer');
    cy.get('#invitation_is_family').check();
    cy.contains('.btn.btn-primary', 'Speichern').click();
  })
})