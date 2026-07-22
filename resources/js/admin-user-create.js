import intlTelInput from 'intl-tel-input/intlTelInputWithUtils';
import fr from 'intl-tel-input/i18n/fr';
import 'intl-tel-input/styles';

document.addEventListener('DOMContentLoaded', () => {
    const phoneInput = document.querySelector('#phone');
    const countrySelect = document.querySelector('#pays');

    if (!phoneInput || !countrySelect) {
        return;
    }

    const pageLocale = document.documentElement.lang || 'fr';
    const displayNames = typeof Intl.DisplayNames === 'function'
        ? new Intl.DisplayNames([pageLocale], { type: 'region' })
        : null;
    const selectedCountry = countrySelect.dataset.selected || '';

    const countries = intlTelInput.getCountryData()
        .map((country) => ({
            iso2: country.iso2,
            name: displayNames?.of(country.iso2.toUpperCase()) || country.name,
        }))
        .sort((first, second) => first.name.localeCompare(second.name, pageLocale));

    countrySelect.replaceChildren(countrySelect.options[0]);

    countries.forEach((country) => {
        const option = document.createElement('option');
        option.value = country.name;
        option.textContent = country.name;
        option.dataset.iso2 = country.iso2;
        option.selected = selectedCountry === country.name;
        countrySelect.append(option);
    });

    const phone = intlTelInput(phoneInput, {
        initialCountry: 'fr',
        countryOrder: ['fr', 'be', 'ch', 'de', 'gb', 'us', 'ca'],
        countrySearch: true,
        separateDialCode: true,
        strictMode: true,
        i18n: fr,
    });

    const clearPhoneError = () => {
        phoneInput.setCustomValidity('');
        phoneInput.removeAttribute('aria-invalid');
    };

    phoneInput.addEventListener('input', clearPhoneError);
    phoneInput.addEventListener('countrychange', clearPhoneError);

    phoneInput.form?.addEventListener('submit', (event) => {
        if (!phoneInput.value.trim()) {
            return;
        }

        if (!phone.isValidNumber()) {
            event.preventDefault();
            phoneInput.setCustomValidity(phoneInput.dataset.invalidMessage || 'Numéro de téléphone invalide.');
            phoneInput.setAttribute('aria-invalid', 'true');
            phoneInput.reportValidity();
            return;
        }

        clearPhoneError();
        phoneInput.value = phone.getNumber();
    }, { capture: true });
});
