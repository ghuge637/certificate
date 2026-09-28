package com.automation.system.certificate.model;

import jakarta.persistence.*;
import java.time.LocalDate;

@Entity
@Table(name = "previous_academic_details")
public class PreviousAcademicDetail {

    @Id
    @Column(name = "prnno", nullable = false)
    private Long prnno;

    @Column(name = "mother_name", nullable = false)
    private String motherName;

    private String religion;
    private String caste;

    @Column(name = "place_of_birth")
    private String placeOfBirth;

    private String nationality;

    @Column(name = "dob_in_words")
    private String dobInWords;

    @Column(name = "previous_institute")
    private String previousInstitute;

    @Column(name = "date_of_admission")
    private LocalDate dateOfAdmission;

    private String standard;

    public PreviousAcademicDetail() {
    }

    public PreviousAcademicDetail(Long prnno, String motherName, String religion, String caste, String placeOfBirth, String nationality, String dobInWords, String previousInstitute, LocalDate dateOfAdmission, String standard) {
        this.prnno = prnno;
        this.motherName = motherName;
        this.religion = religion;
        this.caste = caste;
        this.placeOfBirth = placeOfBirth;
        this.nationality = nationality;
        this.dobInWords = dobInWords;
        this.previousInstitute = previousInstitute;
        this.dateOfAdmission = dateOfAdmission;
        this.standard = standard;
    }

    public Long getPrnno() {
        return prnno;
    }

    public void setPrnno(Long prnno) {
        this.prnno = prnno;
    }

    public String getMotherName() {
        return motherName;
    }

    public void setMotherName(String motherName) {
        this.motherName = motherName;
    }

    public String getReligion() {
        return religion;
    }

    public void setReligion(String religion) {
        this.religion = religion;
    }

    public String getCaste() {
        return caste;
    }

    public void setCaste(String caste) {
        this.caste = caste;
    }

    public String getPlaceOfBirth() {
        return placeOfBirth;
    }

    public void setPlaceOfBirth(String placeOfBirth) {
        this.placeOfBirth = placeOfBirth;
    }

    public String getNationality() {
        return nationality;
    }

    public void setNationality(String nationality) {
        this.nationality = nationality;
    }

    public String getDobInWords() {
        return dobInWords;
    }

    public void setDobInWords(String dobInWords) {
        this.dobInWords = dobInWords;
    }

    public String getPreviousInstitute() {
        return previousInstitute;
    }

    public void setPreviousInstitute(String previousInstitute) {
        this.previousInstitute = previousInstitute;
    }

    public LocalDate getDateOfAdmission() {
        return dateOfAdmission;
    }

    public void setDateOfAdmission(LocalDate dateOfAdmission) {
        this.dateOfAdmission = dateOfAdmission;
    }

    public String getStandard() {
        return standard;
    }

    public void setStandard(String standard) {
        this.standard = standard;
    }
}
