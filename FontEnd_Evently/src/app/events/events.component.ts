import { Component } from '@angular/core';
import { EventService } from '../event.service';

@Component({
  selector: 'app-events',
  templateUrl: './events.component.html',
  styleUrls: ['./events.component.css']
})
export class EventsComponent {
  event = {
    name: '',
    description: '',
    capacity: 0,
    details: '',
    date_e: '' // Ensure the property name matches the one in the PHP script
  };
  
  events: any[] = []; // Array to store fetched events
  searchTerm: string = ''; // Define searchTerm property
  noResults: boolean = false; // Define noResults flag


  constructor(private eventService: EventService) { }

  ngOnInit(): void {
    this.fetchEvents(); // Fetch events when the component initializes
  }

  onSubmit(): void {
    this.eventService.addEvent(this.event).subscribe((response: any) => {
      console.log('Event added successfully:', response);
      // Reset the form after successful submission
      this.event = {
        name: '',
        description: '',
        capacity: 0,
        details: '',
        date_e: '' // Ensure the property name matches the one in the PHP script
      };
      // Refresh the list of events after adding a new one
      this.fetchEvents();
    }, (error: any) => {
      console.error('Error adding event:', error);
    });
  }

  fetchEvents(): void {
    this.eventService.getEvents().subscribe((events: any[]) => {
      this.events = events || []; // Ensure events is initialized even if response is null or undefined
      console.log('Events fetched successfully:', this.events);
    }, (error: any) => {
      console.error('Error fetching events:', error);
    });
  }

  onSearch(): void {
    // Call searchEvent method with searchTerm
    this.eventService.searchEvents(this.searchTerm).subscribe((events: any[]) => {
      this.events = events || [];
      this.noResults = this.events.length === 0; // Set noResults flag based on search results
      console.log('Events fetched successfully:', this.events);
    }, (error: any) => {
      console.error('Error searching events:', error);
    });
  }
}
